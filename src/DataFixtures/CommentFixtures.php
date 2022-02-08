<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1 ; $i <= 10 ; $i++) {
            $comment = new Comment();
            $comment->setContenu('Ceci est le contenu du commentaire');
            $comment->setAuthor('Ash');
            $comment->setDateComment(new \DateTime());
            $comment->setArticle($this->getReference('article-'.$i));

            $manager->persist($comment);
        }


        $manager->flush();
    }

    public function getDependencies() {
        return [
            ArticleFixtures::class
        ];
    }
}
