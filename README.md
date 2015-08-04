PHP Process Control
===================

This little coding test was done to play a little
bit with parallel execution of PHP scripts by creating
and monitoring UNIX processes.

Thanks [Dale Hurley](https://github.com/dalehurley) for inspiration with
(https://github.com/dalehurley/PHP-Process-Manager).


# How does it work?

There are two classes

* Process.php
* ProcessManager.php

and two PHP scripts for demo:

* doit.php: This is the worker PHP script that is subject to be executed. It runs 30 seconds.
* php-process.php: This starts the demo.


## Process

A *Process* represents a UNIX process.

##  ProcessManager

The ProcessManager takes a list of PHP scripts and executes them in parallel
with a configurable maximum of parallellzation.

Every PHP script is killed if the execution time is exceeded.