<?php

require_once dirname(__FILE__) . '/../vendor/autoload.php';

$config = array(
    'host' => '127.0.0.1',
    'port' => '6379',
);

$lmtr = new RtLmtr\RtLmtr($config);

$id1 = 123123;
$id2 = 234234;

$string = sprintf("%s%s", sha1($id1), sha1($id2));

echo $string . "\n";

$rv = $lmtr->rateLimitSimple($string, 10);

var_dump($rv);

$rv = $lmtr->rateLimitSimple($string, 10);

var_dump($rv);

sleep(11);

$rv = $lmtr->rateLimitSimple($string, 10);

var_dump($rv);
$rv = $lmtr->rateLimitSimple($string, 10);

var_dump($rv);

