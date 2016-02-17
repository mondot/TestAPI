<?php

namespace IronWeb\APIBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use IronWeb\APIBundle\Tests\Fixtures\Entity\LoadArticleData;

class ArticleRestControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->auth = array(
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'userpass',
        );
        $this->client = static::createClient(array(), $this->auth);
    }

    public function testJsonGetArticlesAction()
    {
        $fixtures = array('IronWeb\APIBundle\Tests\Fixtures\Entity\LoadArticleData');
        $this->loadFixtures($fixtures);
        $articles = LoadArticleData::$articles;
        $article = array_pop($articles);

        $route =  $this->getUrl('api_get_article', array('article' => $article->getId(), '_format' => 'json'));
        $this->client->request('GET', $route, array('ACCEPT' => 'application/json'));
        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, 200);
        $content = $response->getContent();

        $decoded = json_decode($content, true);
        $this->assertTrue(isset($decoded['id']));
    }

    protected function assertJsonResponse(
            $response, 
            $statusCode = 200, 
            $checkValidJson =  true, 
            $contentType = 'application/json'
        )
        {
            $this->assertEquals(
                $statusCode, $response->getStatusCode(),
                $response->getContent()
            );
            $this->assertTrue(
                $response->headers->contains('Content-Type', $contentType),
                $response->headers
            );
            if ($checkValidJson) {
                $decode = json_decode($response->getContent());
                $this->assertTrue(($decode != null && $decode != false),
                    'is response valid json: [' . $response->getContent() . ']'
                );
            }
        }
}