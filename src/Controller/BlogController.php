<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Faker\Provider\en_US\Text;


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
     * @Route("/blog/{id}/edit", name="edit_article")
     */

    public function create(Article $article = null, Request $request, EntityManagerInterface $em)
    {







        if (!$article) {
            $article = new Article();
        }


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {;
            dump($article);
            if (!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }

            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }



        return $this->render('/blog/create.html.twig', ['form' => $form->createView(), "isUpdate" => $article->getId()]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */

    public function show(ArticleRepository $articleRepo, Article $article, Request $request, EntityManagerInterface $em)
    {

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $comment->setAuthor($this->getUser()->getUsername());
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute("blog_show", ["id" => $article->getId()]);
        }

        return $this->render('blog/show.html.twig', ['article' => $article, "comment" => $form->createView()]);
    }
}