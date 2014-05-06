<?php

namespace RtLmtr;

use RtLmtr\Interfaces\DriverInterface;

class RtLmtr {

    protected $driver;

    public function __construct(DriverInterface $driver) {
        $this->driver = $driver;
    }

    public function rateLimitSimple($key, $expire) {
        $current = $this->driver->get($key);
        if (false === $current) {
            return $this->driver->incr($key, $expire);
        }
        return false;
    }

    public function rateLimitCounter($key, $max, $expire) {
        $current = $this->driver->get($key);
        if (($current != false) && ($current >= $max)) {
            return false;
        } else {
          if ($current == false) {
            return (false !== $this->driver->incr($key, $expire));
          } else {
            return (false !== $this->driver->incr($key, null));
          }
        }
        return false;
    }

    public function get($key) {
      return $this->driver->get($key);
    } 
}

