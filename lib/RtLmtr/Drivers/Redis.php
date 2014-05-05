<?php
namespace RtLmtr\Drivers;

use RtLmtr;
use RtLmtr\Interfaces\DriverInterface;

class Redis implements DriverInterface
{
  protected $redis;

  public function __construct(array $options = array()) {
    if (!class_exists('Redis')) {
      throw new \Exception('Please enable Redis extension!');
    }
    $this->redis = new \Redis();
    $this->redis->connect($options["host"], $options["port"]);
    if (isset($options['auth']))  $this->redis->auth($options["auth"]);
  }

  public function set($key, $value, $expiry = null) {
    $this->redis->set($key, $value);
    if (null != $expiry) {
      $this->redis->expire($key, intval($exp));
    }
  }

  public function get($key) {
    return $this->redis->get($key);
  }

  public function incr($key, $expiry = null) {
    $this->redis->incr($key);
    if (null != $expiry) {
      $this->redis->expire($key, intval($expiry));
    }
  }

}
