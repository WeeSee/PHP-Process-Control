PHP Process Control
===================

This coding exercise was done to play a little
bit with parallel execution of PHP scripts by creating
and monitoring UNIX processes.

Result: I'm happy it works!

Thanks [Dale Hurley](https://github.com/dalehurley) for inspiration with
https://github.com/dalehurley/PHP-Process-Manager.


# How does it work?

There are two classes in

* Process.php
* ProcessManager.php

and two PHP user scripts for demo:

* doit.php: This is the worker PHP script that is subject to be executed. It runs 30 seconds.
* php-process.php: This starts the demo.

## The class Process

A **Process** represents a UNIX process

## The class ProcessManager

The **ProcessManager** takes a list of PHP scripts and executes them in parallel
with a configurable maximum of parallellzation. This is a nice feature to avoid
polluting your system with PHP processes.

Every PHP script is killed if the execution time is exceeded.

# Demo

The main lines in php-process.php are (the number denotes seconds after
the script is going to be killed):

```
	$manager->addScript("doit.php 1", 5);
	$manager->addScript("doit.php 2", 10);
	$manager->addScript("doit.php 3", 35);
	$manager->addScript("doit.php 4", 5);
	$manager->addScript("doit.php 5", 10);
	$manager->addScript("doit.php 6", 35);
```

On my Ubuntu system the demo output ist started by

```
php php-process.php
```

and then shows:

```
Added & started script: doit.php 1 (pid=25220)
Added & started script: doit.php 2 (pid=25221)
Added & started script: doit.php 3 (pid=25222)
doit.php 1 (25220): starting & sleeping for 30 seconds
doit.php 3 (25222): starting & sleeping for 30 seconds
doit.php 2 (25221): starting & sleeping for 30 seconds
Killed: doit.php 1 (pid=25220) after 5 seconds
Added & started script: doit.php 4 (pid=25226)
doit.php 4 (25226): starting & sleeping for 30 seconds
Killed: doit.php 2 (pid=25221) after 10 seconds
Added & started script: doit.php 5 (pid=25228)
doit.php 5 (25228): starting & sleeping for 30 seconds
Killed: doit.php 4 (pid=25226) after 5 seconds
Added & started script: doit.php 6 (pid=25230)
doit.php 6 (25230): starting & sleeping for 30 seconds
Killed: doit.php 5 (pid=25228) after 10 seconds
doit.php 3 (25222): ready
Done: doit.php 3 pid=25222
doit.php 6 (25230): ready
Done: doit.php 6 pid=25230
```





