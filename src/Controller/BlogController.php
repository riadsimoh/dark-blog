<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
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


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {;

            $article->setCreatedAt(new \DateTime());
            $article = $form->getData();

            $em->persist($article);
            $em->flush();
        }



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