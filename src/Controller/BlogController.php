<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 3/9/2019
 * Time: 2:52 PM
 */

namespace App\Controller;


use App\Service\Greeting;
use App\Service\VeryBadDesign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

//class BlogController extends AbstractController
//class BlogController extends Controller

/**
 * @Route("/blog")
 */
class BlogController
{
//    /**
//     * @var Greeting
//     */
//    private $greeting;

    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var RouterInterface
     */
    private $router;

//    /**
//     * @var VeryBadDesign
//     */
//    private $badDesign;
//    public function __construct(
//        Greeting $greeting,
//        VeryBadDesign $badDesign
//    ) {
//        $this->greeting = $greeting;
//        $this->badDesign = $badDesign;
//    }
    public function __construct(
        \Twig_Environment $twig,
        SessionInterface $session,
        RouterInterface $router
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->router = $router;
    }

    //@Route("/", name="blog_index")
    //* @Route("/{name}", name="blog_index")
    /**
     * @Route("/", name="blog_index")
     */
    //public function index(Request $request)
//    public function index($name)
    public function index()
    {
//        $this->get("app.greeting");

//         return $this->render('base.html.twig', ['message' => $this->greeting->greet(
//             $request->get('name')
//         )]);
         $html = $this->twig->render('blog/index.html.twig',
             [
                 'posts' => $this->session->get('posts')
             ]
         );
         return new Response($html);
    }

    /**
     * @Route("/add", name="blog_add")
     */
    public function add()
    {
        $posts = $this->session->get('posts');
        $posts[uniqid()] = [
            'title' => 'A random title' . rand(1, 500),
            'text' => 'Some random text nr' . rand(1, 500),
            'date' => new \DateTime(),
        ];
        $this->session->set('posts', $posts);

        return new RedirectResponse($this->router->generate('blog_index'));
    }
    /**
     * @Route("/show/{id}", name="blog_show")
     */
    public function show($id)
    {
        $posts = $this->session->get('posts');
        if (!$posts || !isset($posts[$id])){
            throw new NotFoundHttpException('Post not found');
        }

        $html = $this->twig->render(
            'blog/post.html.twig',
            [
                'id' => $id,
                'post' => $posts[$id]
            ]
        );

        return new Response($html);
    }

}