<?php 

namespace IronWeb\APIBundle\Controller;

use IronWeb\APIBundle\Entity\Article;
use IronWeb\APIBundle\Entity\ArticleRate;
use IronWeb\APIBundle\Form\ArticleType;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;



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

      // $validator = $this->get('validator');
      // $listErrors = $validator->Validate($articleRate);

      // if ($listErrors==0) {
      // 	$manager = $this->getDoctrine()->getManager();
      // 	$manager->persist($articleRate);
      // 	$manager->flush();
      // }

      // return new Response("Congratulations! the number of errors is $listErrors");

      $manager = $this->getDoctrine()->getManager();
      $manager->persist($articleRate);
      $manager->flush();

    }
}