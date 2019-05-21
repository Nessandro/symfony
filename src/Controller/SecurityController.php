<?php
/**
 * Class SecurityController
 * User: Nessandro
 * Date: 2019-05-18
 * Time: 14:58
 * @package App\Controller
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\CommentType;
use App\Form\RegistartionUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{


    /**
     * @Route("/login", name="login_form")
     */
    public function login(AuthenticationUtils $auth)
    {
        return $this->render('app/login.html.twig', [
            'remembered_user' => $auth->getLastUsername(),
            'error' => $auth->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="logout_security")
     */
    public function logout()
    {

    }

    /**
     *
     * @Route("/registration", name="registration")
     */
    public function registration(UserPasswordEncoderInterface $encoder, Request $request)
    {
        $user = new User();

        $form = $this->createForm(RegistartionUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Are you registred succesfully.');

            return $this->redirectToRoute('homepage', []);
        }

        return $this->render('app/registration.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}