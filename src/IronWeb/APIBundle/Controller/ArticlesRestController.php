<?php 

namespace IronWeb\APIBundle\Controller;

use IronWeb\APIBundle\Entity\Article;
use IronWeb\APIBundle\Form\ArticleType;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ArticlesRestController extends FOSRestController
{
  public function getArticleAction(Article $article){
    return $article;
  }

  /**
   * retrieve all articles
   * TODO: add pagination
   *
   * @return Article[]
   */
  public function getArticlesAction()
  {
      $articles = $this
          ->getDoctrine()
          ->getRepository('IronWebAPIBundle:Article')
          ->findAll();

      return $articles;
  }

  public function postArticlesAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(
            new ArticleType(),
            $article
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();

        // created => 200
        return new Response("Congratulations!");
        }

    }
}