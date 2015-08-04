<?php
   
	require_once("ProcessManager.php");
   
	$manager              = new ProcessManager();
	//$manager->executable  = "php";


	$manager->addScript("doit.php 1", 5);
	$manager->addScript("doit.php 2", 10);
	$manager->addScript("doit.php 3", 35);
	$manager->addScript("doit.php 4", 5);
	$manager->addScript("doit.php 5", 10);
	$manager->addScript("doit.php 6", 35);

	$manager->exec();
   
