<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Loggable\Entity\Repository\LogEntryRepository;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
class LogEntry extends \Gedmo\Loggable\Entity\LogEntry
{

}