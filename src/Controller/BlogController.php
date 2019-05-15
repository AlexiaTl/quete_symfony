<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog", name="blog_")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="index")
    */
    public function index()
    {
        return $this->render('blog/index.html.twig', [
            'owner' => 'Alexia',
        ]);
    }


    /**
     * @Route("/list/{page<\d+>?1}", name="list")
     */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }


    /**
     * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug"="Article Sans Titre"}, name="show")
     */
    public function show($slug){
        $slug = preg_replace("/-/"," ", ucwords(trim(strip_tags($slug)), "-"));
        return $this->render('blog/show.html.twig', ['slug' => $slug]);
    }
}