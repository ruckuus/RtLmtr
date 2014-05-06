<?php

namespace RtLmtr\Drivers;
use RtLmtr\Interfaces\DriverInterface;

class Memcache implements DriverInterface
{
  protected $memcache;

  public function __construct(array $options = array()) {
    if (!class_exists('Memcache')) {
      throw new \Exception('Please enable Memcache extension');
    }

    $memcache = new \Memcache();
    $memcache->connect($options["host"], $options["port"]);
    $this->memcache = $memcache;
  }

  public function set($key, $value, $expiry = null) {
    $expr = $this->getExpiry($expiry);
    return $this->memcache->set($key, $value, 0, $expr);
  }

  public function get($key) {
    return $this->memcache->get($key);
  }

  public function incr($key, $expiry = null) {
    $expr = $this->getExpiry($expiry);
    $current = $this->memcache->get($key);
    if (false === $current) {
      return $this->memcache->set($key, 1, 0, $expr);
    } else {
      $current++;
      return $this->memcache->set($key, $current, 0, $expr);
    }
  }

  private function getExpiry($expiry) {
    $expr = (null === $expiry) ? 0 : intval($expiry);
    return $expr;
  }
}

