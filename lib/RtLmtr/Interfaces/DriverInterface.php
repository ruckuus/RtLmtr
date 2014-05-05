<?php

namespace RtLmtr\Interfaces;

interface DriverInterface
{
  public function set($key, $value, $expiry = null);
  public function get($key);
  public function incr($key, $expiry = null);
}
