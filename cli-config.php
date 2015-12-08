<?php
$system_path = 'system';
$application_folder = 'application';
define('BASEPATH', str_replace("\\", "/", $system_path));
define('APPPATH', $application_folder.'/');

include __DIR__."/vendor/autoload.php";
include __DIR__."/application/libraries/Doctrine.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(Doctrine::getEntityManager());