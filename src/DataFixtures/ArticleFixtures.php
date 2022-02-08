<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $state = ['brouillon', 'publier'];
        for ($i=1 ; $i<=10 ; $i++) {
            $article = new Article();
            $article->setTitre('Article n°'.$i);
            $article->setContenu("Ceci est le contenu de l'article");
            $date = new \DateTime();
            $date->modify('-'.$i.'days');
            $article->setDateCreation($date);
            $article->setState($state[array_rand($state)]);

            $this->addReference('article-'.$i, $article);
            // ajouter une reference dans l'article qu'on cree pour pouvoir le relier a un commentaire
            $manager->persist($article); //cree notre objet et lui donner un id
        }

        $manager->flush();
    }
}
