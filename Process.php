<?php


/*
 * A Process represents a single unix process that
 * - is started upon creation
 * - can be checked if still running
 * - can be killed if time limit is exeeded
 *
 * Idea from: https://github.com/dalehurley/PHP-Process-Manager
 */

class Process {
	
	static public $phpInterpreter = "/usr/bin/php";
	public $phpScript;
	public $max_execution_time;
	public $pid;
	protected $pipes = array();
	protected $start_time;
	protected $_resource;

	function __construct($phpScript,$max_execution_time)
	{
		$this->phpScript = $phpScript;
		$this->max_execution_time = $max_execution_time;
		$descriptorspec    = array(
			0 => array('pipe', 'r'),
			1 => STDOUT,//array('pipe', 'w'),
			2 => array('pipe', 'w')
		);
		$starttime=microtime(true);
		
		// exec is required to replace shell execution "sh -c"
		// exec is a builtin command in bash, busybox,...
		$this->_resource = proc_open(
			"exec ".self::$phpInterpreter." ".$this->phpScript,
			$descriptorspec,
			$this->pipes,
			null,  	// cwd ist gleiches directory
			null	// env wie vom parent
		);
		$dauer = microtime(true) - $starttime;
		//echo "Duration: procopen $dauer\n";
		$status = proc_get_status($this->_resource);
		$this->pid=$status["pid"];
		$this->start_time = time();
	}
	
	// is still running?
	public function isRunning()
	{
		if (!isset($this->_resource))
			return false;
		$status = proc_get_status($this->_resource);
		return $status["running"];
	}

	// long execution time, proccess is going to be killer
	function isOverExecuted()
	{
		if (isset($this->_resource)
			&& $this->start_time+$this->max_execution_time<time())
			return true;
		else
			return false;
	}
	
	public function terminate()
	{
		if (isset($this->_resource))
			proc_terminate($this->_resource);
	}
	
	public function close()
	{
		$returnCode = proc_close($this->_resource);
		unset($this->_resource);
		return $returnCode;
	}

	
}