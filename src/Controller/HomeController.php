<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 * User: Nessandro
 * Date: 2019-05-18
 * Time: 08:56
 */

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $posts = $this->getDoctrine()->getRepository(Post::class);

        return $this->render('app/homepage.html.twig',[
            'pagination' => $paginator->paginate($posts->findAll(), $request->query->getInt('page',1),5),
        ]);
    }

    /**
     * @Route("/article/{id}", name="show_post")
     */
    public function showPost(Post $post, Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted('ROLE_USER'))
        {
            $comment = new Comment();
            $comment->setPost($post);

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid())
            {
                $comment->setUser($this->getUser());
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($comment);
                $manager->flush();

                $this->addFlash('success', 'The comment has been added succesfully.');

                return $this->redirectToRoute('show_post', ['id' =>$post->getId()]);
            }
        }

        return $this->render('app/show_article.html.twig', [
            'post' => $post,
            'form' => isset($form) ? $form->createView() : '',
        ]);
    }

}