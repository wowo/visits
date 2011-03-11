<?php
namespace Sznapka\VisitsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sznapka\VisitsBundle\Document\Visit;

/**
 * Main Controller 
 * 
 * @uses Controller
 * @package 
 * @version $id$
 * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
 * @license 
 */
class MainController extends Controller
{
  /**
   * welcome action 
   *  
   * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
   * @access public
   * 
   * @return void
   */
  public function welcomeAction()
  {
    return $this->render('VisitsBundle:Main:welcome.html.twig');
  }

  /**
   * register action 
   *  
   * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
   * @access public
   * 
   * @param  mixed $source 
   * @return void
   */
  public function registerAction($source)
  {
    $visit = new Visit();
    $visit->source = $source;
    $visit->date   = new \DateTime("now");
    $visit->userAgent = $this->get("request")->server->get("HTTP_USER_AGENT");
    $visit->referer   = $this->get("request")->server->get("HTTP_REFERER");
    $visit->ip        = $this->get("request")->server->get("REMOTE_ADDR");
    $visit->host      = gethostbyaddr($visit->ip);

    $dm = $this->get('doctrine.odm.mongodb.app_document_manager');
    $dm->persist($visit);
    $dm->flush();

    $response = new Response($this->getFakeImage());
    $response->headers->set("Content-Type", "image/png");
    return $response;
  }

  public function statsAction($day)
  {
    $docs = $this->get("odm.repository.visit")->getVisitsForDay(new \DateTime($day));
    return $this->render("VisitsBundle:Main:stats.html.twig", array("day" => $day, "docs" => $docs));
  }

  /**
   * get fake image 
   *  
   * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
   * @access protected
   * 
   * @return void
   */
  protected function getFakeImage()
  {
    $im = imagecreatetruecolor(1, 1); 
    imagecolortransparent($im, imagecolorallocate($im, 0, 0, 0));
    ob_start();
    imagepng($im);
    $image = ob_get_contents();
    imagedestroy($im); 
    return $image;
  }
}
