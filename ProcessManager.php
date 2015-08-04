<?php



require_once("Process.php");

class ProcessManager
{
    
	//public $executable       = "php";	//the system command to call
	//public $root             = "";		//the root path
	public $processes        = 3;		//max concurrent processes
	public $sleep_time       = 1;		//time between processes
	public $show_output      = false;	//where to show the output or not
	
	private $running          = array();//the list of scripts currently running
	private $scripts          = array();//the list of scripts - populated by addScript
	private $processesRunning = 0;		//count of processes running	

	
	function addScript($script, $max_execution_time = 5)
	{
		$this->scripts[] = array(
            "script_name" => $script,
            "max_execution_time" => $max_execution_time
        );
	}

	function exec()
	{
		$i = 0;
		for(;;)
		{
			// Fill up the slots
			while (($this->processesRunning<$this->processes)
                   and ($i<count($this->scripts)))
			{
                $this->running[] =& new Process(
                    $this->scripts[$i]["script_name"],
                    $this->scripts[$i]["max_execution_time"]
                );
                echo "Added & started script: ".$this->scripts[$i]["script_name"].
                     " (pid=".end($this->running)->pid.")\n";
				$this->processesRunning++;
				$i++;
			}

			// Check if done
			if (($this->processesRunning==0) and ($i>=count($this->scripts))) {
				break;
			}

			// sleep, this duration depends on your script execution time, the longer execution time, the longer sleep time
			sleep($this->sleep_time);

			// check what is done
			foreach ($this->running as $key => $process)
			{
                //echo "checking ".$val->pid."\n";
				if (!$process->isRunning() or $process->isOverExecuted())
				{
                    if (!$process->isRunning())
                    {
                        echo "Done: ".$process->phpScript." pid=".$process->pid."\n";
                    } else
                    {
                        $process->terminate();
                        echo "Killed: ".$process->phpScript." (pid=".$process->pid.")".
                            " after ".$process->max_execution_time." seconds\n";
                    }
                    $process->close();
                    
                    unset($this->running[$key]);
                    $this->processesRunning--;
                }
			}
		}
	}
}
