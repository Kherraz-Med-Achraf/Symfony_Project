<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin")
 */

class AdminController extends AbstractController
{
    /**
     * @Route ("/article/ajouter", name="ajout_articles")
     * @Route ("/article/{id}/edition", name="edition_article" , requirements={"id"="\d+"} , methods={"GET", "POST"})
     */

    public function ajouter (Article $article = null, Request $request,  EntityManagerInterface $manager){

        if ($article === null) {
            $article = new Article(); //on cree l'article dans le cas de l'ajout donc article null
        }


        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            if ($form->get('brouillon')->isClicked()) {
                $article->setState('brouillon');
            }
            else {
                $article->setState('publier');
            }

            if ($article->getId() === null) {
                $manager->persist($article); //on persiste seulement si l'article n'existe pas
            }

            $manager->flush();

            return $this->redirectToRoute('liste_articles');

        }


        return $this->render('default/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route ("/article/brouillon" , name="brouillon_article")
     */
    public function brouillon(ArticleRepository $articleRepository){
        $articles = $articleRepository->findBy([
            'state' => 'brouillon'
        ]);

        return $this -> render('default/index.html.twig', [
            'articles' => $articles,
            'brouillon' => true
        ]);
    }
}
