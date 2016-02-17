<?php 

namespace IronWeb\APIBundle\Controller;

use IronWeb\APIBundle\Entity\Article;
use IronWeb\APIBundle\Entity\ArticleRate;
use IronWeb\APIBundle\Entity\ArticleAnswer;
use IronWeb\APIBundle\Form\ArticleType;
use IronWeb\APIBundle\Form\ArticleAnswerType;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



class ArticlesRestController extends FOSRestController
{
	/**
  * @Rest\View
  * @ApiDoc(
  *   resource = true,
  *   description = "Gets a Article for a given id",
  *   output = "IronWeb\APIBundle\Entity\Article",
  *   statusCodes = {
  *     200 = "Returned when successful",
  *     404 = "Returned when the page is not found"
  *   }
  * )
  */
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

  /**
  * @Rest\View
  */
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

      // created => 201
      return new View($article, Response::HTTP_CREATED);
      }

      return new View(
              Response::HTTP_UNPROCESSABLE_ENTITY
      );

    }

  /**
  * @Rest\View
  */
  public function putArticleRateAction($id,$rate)
    {

      $em = $this->getDoctrine()->getManager();

      $article = $em
        ->getRepository('IronWebAPIBundle:Article')
        ->find($id)
      ;

      if (null == $article) {
        throw new NotFoundHttpException("The article with id ".$id." does not exist.");
      }

      $articleRate = new ArticleRate();
      $articleRate->setArticle($article);
      $articleRate->setRate($rate);

      $validator = $this->get('validator');
      $listErrors = $validator->validate($articleRate);

      if (count($listErrors)>0) {
      	return new View(
              $listErrors,
              Response::HTTP_UNPROCESSABLE_ENTITY
           );
      }

      $manager = $this->getDoctrine()->getManager();
      $manager->persist($articleRate);
      $manager->flush();

      // created => 201
      return new View($articleRate, Response::HTTP_CREATED);
    }

  /**
  * @Rest\View
  */
  public function putArticleAnswerAction($id,Request $request)
    {

      $em = $this->getDoctrine()->getManager();

      $article = $em
        ->getRepository('IronWebAPIBundle:Article')
        ->find($id)
      ;

      if (null == $article) {
        throw new NotFoundHttpException("The article with id ".$id." does not exist.");
      }

      $answer = new ArticleAnswer();
      $answer->setArticle($article);

      $form = $this->createForm(
          new ArticleAnswerType(),
          $answer,
          array('method' => 'PUT')
      );

      $form->handleRequest($request);

      if ($form->isValid()) {

      $manager = $this->getDoctrine()->getManager();
      $manager->persist($answer);
      $manager->flush();

      // created => 201
      return new View($answer, Response::HTTP_CREATED);
      }

      return new View(
              Response::HTTP_UNPROCESSABLE_ENTITY
      );
    }
}