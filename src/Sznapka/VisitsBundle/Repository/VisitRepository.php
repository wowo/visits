<?php
namespace Sznapka\VisitsBundle\Repository;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Sznapka\VisitsBundle\Document\Visit;

/**
 * visit repository 
 * 
 * @uses DocumentRepository
 * @package 
 * @version $id$
 * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
 * @license 
 */
class VisitRepository extends DocumentRepository
{
  /**
   * Get Visits for given day
   *  
   * @author Wojciech Sznapka <wojciech.sznapka@xsolve.pl> 
   * @access public
   * 
   * @param  \DateTime $date 
   * @return void
   */
  public function getVisitsForDay(\DateTime $date)
  {
    $start = clone $date;
    $start->setTime(0, 0);
    $stop = clone $date;
    $stop->setTime(23, 59);

    $query = $this->createQueryBuilder();
    $query->field("date")->range($start, $stop);
    $query->sort("date", "asc");
    $docs = $query->getQuery()->execute();
    $result = array();
    foreach ($docs as $doc) {
      if (!isset($result[$doc->source])) {
        $result[$doc->source] = array();
      }
      $result[$doc->source][] = $doc;
    }
    return $result;
  }
}
