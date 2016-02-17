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
  *     404 = "Returned when the article is not found"
  *   }
  * )
  * @param Request $request the request object
  * @param int     $id      the page id
  * 
  * @return array
  *
  * @throws NotFoundHttpException when page not exist
  */

  public function getArticleAction(Article $article){
    return $article;
  }

  /**
  * @Rest\View
  * @ApiDoc(
  *   resource = true,
  *   description = "Gets all the Articles",
  *   output = "IronWeb\APIBundle\Entity\Article",
  *   statusCodes = {
  *     200 = "Returned when successful",
  *     404 = "Returned when no articles"
  *   }
  * )
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
  * @ApiDoc(
  *   resource = true,
  *   description = "Posts an article",
  *   output = "IronWeb\APIBundle\Entity\Article",
  *   statusCodes = {
  *     201 = "Returned when successful",
  *     422 = "Returned when unprocessable entity"
  *   }
  * )
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

      $validator = $this->get('validator');
      $listErrors = $validator->validate($article);
      return new View(
              $listErrors,
              Response::HTTP_UNPROCESSABLE_ENTITY
      );

    }

  /**
  * @Rest\View
  * @ApiDoc(
  *   resource = true,
  *   description = "Puts a rate to a given id article",
  *   statusCodes = {
  *     201 = "Returned when successful",
  *     422 = "Returned when unprocessable entity"
  *   }
  * )
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
  * @ApiDoc(
  *   resource = true,
  *   description = "Puts an answer to a given id article",
  *   input = "IronWeb\APIBundle\Entity\ArticleAnswer",
  *   statusCodes = {
  *     201 = "Returned when successful",
  *     422 = "Returned when unprocessable entity"
  *   }
  * )
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

      $validator = $this->get('validator');
      $listErrors = $validator->validate($article);

      return new View(
              $listErrors,
              Response::HTTP_UNPROCESSABLE_ENTITY
      );
    }
}