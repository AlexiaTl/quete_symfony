<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;


class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
            'No article found in article\'s table.'
            );
        }

        return $this->render(
                'blog/index.html.twig',
                ['articles' => $articles]
        );
    }

    /**
     * @Route("/blog/list/{page<\d+>?1}", name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }


    /**
     * @Route("/blog/show/{slug<^[a-z0-9-]+$>?Article Sans Titre}", name="blog_show")
     */
    public function show($slug){
        $slug = ucwords(preg_replace("/-/"," ",$slug));
        return $this->render('blog/show.html.twig', ['slug' => $slug]);
    }
}