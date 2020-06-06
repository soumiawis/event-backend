<?php

namespace App\Controller;


use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * Permet de se connecter et de gerer le formulaire de connxion
     *
     * @Route("/login", name="account_login")
     *
     * @return Response
     */
    public function login(AuthenticationUtils $utils )
    {

        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username

        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout(){
        // ....rien ! merci symfony
    }


    /**
     *Permet d'afficher le formulaire d'inscription
     *
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register(Request $request,EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder){
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success','Compte crée ');

            return  $this->redirectToRoute('account_login');
        }
        return  $this->render('account/registration.html.twig',[
            'form' => $form ->createView()
        ]);
    }

    /**
     * Permet d'afficher et de traiter le formulaire de modification de profil
     *
     * @Route("account/profile", name="account_profile")
     *
     *@IsGranted("IS_AUTHENTICATED_FULLY")
     *
     * @return Response
     *
     */

    public function profile(Request $request,EntityManagerInterface $manager){
        //IS_AUTHENTICATED_FULLY
        //IS_AUTHENTICATED_ANONYMOS
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();


            $this->addFlash('success',
                'les données du profil ont été enregistrer');

        }

        return $this->render('account/profile.html.twig',[

            'form' => $form->createView()
        ]);
    }

    /**
     *Permet de modifier le mot de passe
     *
     * @Route("account/updatePassword", name="account_password")
     *
     * @IsGranted("ROLE_USER")
     *
     * @return  Response
     *
     *
     */
    public function updatePassword(Request $request,UserPasswordEncoderInterface $encoder,EntityManagerInterface $manager){

        $user = $this->getUser();

        $passwordUpdate = new PasswordUpdate();

        $form = $this->createForm(PasswordUpdateType::class,$passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //1.Verifier que le old password du formulaire soit le meme que la password de l'utilisateur
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getPassword())){
        //
            }else {
                     $newPassword = $passwordUpdate->getNewPassword();

                     $hash = $encoder->encodePassword($user,$newPassword);

                     $user->setPassword($hash);

                     $manager->persist($user);

                     $manager->flush();

                     return $this->redirectToRoute('account_login');



            }


        }


        return $this->render('account/password.html.twig',[
            'form'=> $form->createView()
            ]

        );

    }

}
