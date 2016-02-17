<?php

namespace IronWeb\APIBundle\Tests\Fixtures\Entity;

use IronWeb\APIBundle\Entity\Article;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadArticleData implements FixtureInterface
{
    static public $articles = array();

    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setTitle('Test API with IronWeb');
        $article->setAuthor('Quentin');
        $article->setContent('content');
        $manager->persist($article);
        $manager->flush();
        self::$articles[] = $article;
    }
}