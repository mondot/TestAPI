<?php 

namespace IronWeb\APIBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ArticlesRestController extends Controller
{
  public function getArticleAction($title){
    $article = $this->getDoctrine()->getRepository('IronWebAPIBundle:Article')->findOneByTitle($title);
    if(!is_object($article)){
      throw $this->createNotFoundException();
    }
    return $article;
  }
}