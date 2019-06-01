<?php
/**
 * Class PostController
 * User: Nessandro
 * Date: 2019-05-25
 * Time: 11:24
 * @package App\Controller
 */

namespace App\Controller\Base;


use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use App\Libs\LoggManager\Logs\UploadFileLog;
use App\Repository\PostRepository;
use App\Services\Logger;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PostController extends AbstractController
{

    /**
     * @Route("/article/{id}", name="show_post")
     */
    public function showPost(Post $post, Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            $comment = new Comment();
            $comment->setPost($post);

            $form = $this->createForm(CommentType::class, $comment);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $comment->setUser($this->getUser());
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($comment);
                $manager->flush();

                $this->addFlash('success', 'The comment has been added succesfully.');

                return $this->redirectToRoute('show_post', ['id' => $post->getId()]);
            }
        }

        return $this->render('app/show_article.html.twig', [
            'post' => $post,
            'form' => isset($form) ? $form->createView() : '',
        ]);
    }

    /**
     * @Route("/add/article", name="post_new")
     */
    public function addPost(Request $request, Logger $logger)
    {
        if ($this->isGranted('ROLE_USER'))
        {
            $post = new Post();

            $form = $this->createForm(PostType::class, $post);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                /* @var $file \Symfony\Component\HttpFoundation\File\UploadedFile */
                $file = $post->getImage();
                $fileName = $fileName = md5(uniqid()) . '.' . $file->guessExtension();

                try {

                    $file->move($this->getParameter('images_directory'), $fileName);

                    $logger->info(new UploadFileLog($file, UploadFileLog::TYPE_UPLOAD));

                } catch (FileException $e) {
                    $this->addFlash('error', 'Uplod File Error' . $e->getMessage());

                    $logger->error(new UploadFileLog($file, UploadFileLog::TYPE_UPLOAD));

                    return $this->redirectToRoute('post_new', []);
                }

                $post->setUser($this->getUser());
                $post->setImage($fileName);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($post);
                $manager->flush();

                $this->addFlash('success', 'The post has been created succesfully.');

                return $this->redirectToRoute('show_post', ['id' => $post->getId()]);
            }
        }

        return $this->render('app/add_form.html.twig', [
            'form' => isset($form) ? $form->createView() : '',
        ]);
    }

}