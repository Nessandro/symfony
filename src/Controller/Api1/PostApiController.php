<?php


namespace App\Controller\Api1;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/api", name="api")
 */
class PostApiController extends AbstractFOSRestController
{

    /**
     * @Route("/posts", name="api_posts" , methods={"GET"})
     */
    public function getPosts()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class);

        return $this->handleView($this->view($posts->findAll(),Response::HTTP_CREATED));
    }

    /**
     * @Route("/bad/request", name="bad_request" , methods={"GET"})
     */
    public function badRequest()
    {
        $response = ['status' => 'bad request', 'status_code' => 400, 'message'=> 'Bad Request'];
        return $this->handleView($this->view($response,Response::HTTP_BAD_REQUEST));
    }

    /**
     * @Route("/bad/auth", name="bad_auth" , methods={"GET"})
     */
    public function badAuth()
    {
        $response = ['status' => 'unauthorized', 'status_code' => 401, 'message'=> 'Unauthorized'];

        return $this->handleView($this->view($response,Response::HTTP_UNAUTHORIZED));
    }

    /**
     * @Route("/bad/forbidden", name="ba_forbidden" , methods={"GET"})
     */
    public function badForbidden()
    {
        $response = ['status' => 'forbidden', 'status_code' => 403, 'message'=> 'Forbidden'];

        return $this->handleView($this->view($response,Response::HTTP_FORBIDDEN));
    }
}