<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\VerificationComment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route ("/", name="liste_articles", methods={"GET"})
     */
    public function listeArticles (ArticleRepository $articleRepository) : Response {

        $articles = $articleRepository->findBy([
            'state' => 'publier'
        ]);


        return $this -> render('default/index.html.twig', [
            'articles' => $articles,
            'brouillon' => false

        ]);

    }

    /**
     * @Route ("/{id}", name="vue_article", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function vueArticle (Article $article, Request $request, EntityManagerInterface $manager, VerificationComment $verifService , FlashBagInterface $flashBag) : Response {

        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            if ($verifService->commentNonAutoriser($comment) === false) {
                $manager->persist($comment);
                $manager->flush();

                return $this->redirectToRoute('vue_article' , ['id' => $article->getId()]);
            } else {
                $flashBag->add("danger", "Le commentaire contient un mot interdit");
            }
        }




        return $this->render('default/vue.html.twig', [
            'article' => $article,
            //passer l'article recuperer a notre vue
            'form' => $form->createView()
        ]);
    }

}
