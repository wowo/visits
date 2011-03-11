<?php
namespace Sznapka\VisitsBundle\Document;

/**
 * Visit 
 * 
 * @mongodb:Document(collection="visits",repositoryClass="Sznapka\VisitsBundle\Repository\VisitRepository")
 *
 * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
 */
class Visit
{
  /**
   * @mongodb:Id
   */
  public $id;
  /**
   * @mongodb:String
   */
  public $source;
  /**
   * @mongodb:Date
   */
  public $date;
  /**
   * @mongodb:Date
   */
  public $importedAt;
  /**
   * @mongodb:String
   */
  public $userAgent;
  /**
   * @mongodb:String
   */
  public $referer;
  /**
   * @mongodb:String
   */
  public $ip;
  /**
   * @mongodb:String
   */
  public $host;
}
