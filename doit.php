<?php

/*
 * This is the process (a PHP script) that is subject to be controlled
 *
 * Idea from: https://github.com/dalehurley/PHP-Process-Manager
 */

$sleep_time=30;
echo implode(" ",$argv)." (".getmypid()."): starting & sleeping for $sleep_time seconds\n";
for ($i=1;$i<$sleep_time;$i++) sleep(1);
echo implode(" ",$argv)." (".getmypid()."): ready\n";

