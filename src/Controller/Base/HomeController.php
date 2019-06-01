<?php

namespace App\Controller\Base;

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
     * @Route("/about", name="about")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function about(Request $request)
    {

        return $this->render('app/in_progress.html.twig',[]);
    }


}