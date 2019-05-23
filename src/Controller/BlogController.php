<?php
// src/Controller/BlogController.php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Article;
use App\Entity\Category;


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
     * @Route("/blog/show/", name="blog_list")
     */
    public function Default()
    {
        return $this->render('blog/list.html.twig');
    }

    /**
     * @Route("/blog/show/{slug<^[a-z0-9-]+$>?Article Sans Titre}", name="blog_show")
     */
    // redirection vers la page blog show
    public function show($slug){
        $slug = ucwords(preg_replace("/-/"," ",$slug));
        return $this->render('blog/show.html.twig', ['slug' => $slug]);
    }


    /**
     * @param string $categoryName
     * @return Response
     * @Route("/blog/showcategory/{categoryName}", name="show_category")
     */
    public function showByCategory(string $categoryName)
    {
        $category = $this->getDoctrine()->getRepository(Category::class)
            ->findOneBy(['name'=>$categoryName]);
        $articles = $this->getDoctrine()->getRepository(Article::class)
            ->findBy(['category'=>$category->getId()], ['id'=>'DESC'], 3);
        return $this->render('blog/category.html.twig', ['articles' => $articles, 'category' => $categoryName]);
    }

    
    /**
     * @Route("/blog/error/{slug}",
     * requirements={"slug"="[A-Z]+"},
     * defaults={"slug"="UPPER-CASE-NOT-ALLOWED"},
     * name="error")
     */
    public function error($slug)
    {
        // redirection vers la page erreur, correspondant à l'insertion de majuscule dans l'URL
        return $this->render('blog/error_404.html.twig', ['slug' => $slug]);
    }



}