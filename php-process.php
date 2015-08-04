<?php
   
	require_once("ProcessManager.php");
   
	$manager              = new ProcessManager();
	//$manager->executable  = "php";


	$manager->addScript("doit.php 1", 4);
	$manager->addScript("doit.php 2", 4);
	$manager->addScript("doit.php 3", 4);
	$manager->addScript("doit.php 4", 35);
	$manager->addScript("doit.php 5", 35);
	$manager->addScript("doit.php 6", 35);

	$manager->exec();
   
