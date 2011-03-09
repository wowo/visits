<?php
namespace Sznapka\VisitsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sznapka\VisitsBundle\Document\Visit;

/**
 * ImportOperationsCommand 
 * 
 * @uses Command
 * @package default
 * @version $id$
 * @copyright 
 * @author Wojciech Sznapka <wojciech@sznapka.pl> 
 * @license 
 */
class ImportVisitsFromLogFileCommand extends Command
{
  /**
   * configure 
   * 
   * @access protected
   * @return void
   */
  protected function configure()
  {
      parent::configure();
      $this
          ->setName("visits:import-visit-from-log-file")
          ->setDescription("Imports visits from (old) log file")
          ->addOption("path", "p", InputOption::VALUE_REQUIRED, "path to log file");
  }

  /**
   * execute 
   * 
   * @param InputInterface $input 
   * @param OutputInterface $output 
   * @access protected
   * @return void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $path = $input->getOption("path");
    if (!file_exists($path)) {
      throw new \RuntimeException(sprintf("Path %s doesn't exists", $path));
    }
    $output->writeLn(sprintf("Importing visits from old log file located in <info>%s</info>", $path));
    $dm = $this->container->get('doctrine.odm.mongodb.document_manager');

    $entries = file($path);
    $entries = array_map("trim", $entries);
    $i = 0;
    foreach ($entries as $entry) {
      $entry = str_replace("\t", " ", $entry);
      $entry = preg_replace("# {2,}#", " ", $entry);
      $entry = explode(" ", $entry, 4);
      
      $rest = str_replace(array("user agent:", "referer:", "ip: ", "host: "), "###", trim($entry[3]));
      $rest = explode("###", $rest);
      array_shift($rest);
      $rest = array_map("trim", $rest);

      $visit = new Visit();
      $visit->source = trim($entry[0], " []");
      $visit->date = new \DateTime($entry[1] . " " . $entry[2]);
      $visit->importedAt = new \DateTime("now");
      $visit->userAgent = @$rest[0];
      $visit->referer   = @$rest[1];
      $visit->ip        = @$rest[2];
      $visit->host      = @$rest[3];
      $dm->persist($visit);
      $i++;
    }
    $dm->flush();
    $output->writeLn(sprintf("Imported <info>%d</info> visits", $i));
  }
}


