<?php 

namespace IronWeb\APIBundle\Controller;

use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ArticlesRestController extends Controller
{
  public function getArticleAction($name){
    $article = $this->getDoctrine()->getRepository('APIBundle:Article')->findOneByName($name);
    if(!is_object($article)){
      throw $this->createNotFoundException();
    }
    return $article;
  }
}