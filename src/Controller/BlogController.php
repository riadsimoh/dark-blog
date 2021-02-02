<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $articleRepo): Response
    {
        $articles = $articleRepo->findAll();


        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */

    public function home()
    {

        return $this->render('/blog/home.html.twig');
    }

    /**
     * @Route("/blog/new", name="create_article")
     */

    public function create(Request $request, EntityManagerInterface $em)
    {


        $article = new Article();
        $article->setTitle("This is the title")
            ->setContent("This is the content")
            ->setImage("This is the image ")

            ->setCreatedAt(new \DateTime());

        $form = $this->createFormBuilder($article)
            ->add('title')
            ->add('content')
            ->add('image')
            ->getForm();


        dump($form);



        return $this->render('/blog/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */

    public function show(ArticleRepository $articleRepo, Article $article)
    {
        return $this->render('blog/show.html.twig', ['article' => $article]);
    }
}