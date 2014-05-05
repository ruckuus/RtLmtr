<?php

namespace RtLmtr;

use RtLmtr\Interfaces\DriverInterface;

class RtLmtr {

    protected $driver;

    public function __construct(DriverInterface $driver) {
        $this->driver = $driver;
    }

    public function rateLimitSimple($hash, $expire) {
        $current = $this->driver->get($hash);
        if (false === $current) {
            return $this->driver->incr($hash, $expire);
        }
        return false;
    }

    public function rateLimitCounter($hash, $max, $expire) {
        $current = $this->driver->get($hash);
        if (($current != NULL) && ($current >= $max)) {
            return false;
        } else {
            return $this->driver->incr($hash, $expire);
        }
        return false;
    }

    public function get($hash) {
      return $this->driver->get($hash);
    } 
}

