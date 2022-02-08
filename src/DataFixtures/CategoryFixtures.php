<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sport = new Category();
        $sport->setName('Sport');
        $sport->addArticle($this->getReference('article-1'));
        $sport->addArticle($this->getReference('article-2'));
        $sport->addArticle($this->getReference('article-3'));

        $manager->persist($sport);

        $maison = new Category();
        $maison->setName('Maison');
        $maison->addArticle($this->getReference('article-2'));
        $maison->addArticle($this->getReference('article-3'));
        $maison->addArticle($this->getReference('article-4'));

        $manager->persist($maison);

        $manager->flush();


    }

    public function getDependencies() {
        return [
            ArticleFixtures::class
        ];
    }
}
