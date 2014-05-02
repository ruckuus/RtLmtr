<?php
namespace RtLmtr;

class RtLmtr {

    protected $redis;

    public function __construct(array $config = array()) {
        if (!class_exists('Redis')) {
          throw new \Exception('Please enable Redis extension!');
        }

        $this->redis = new \Redis();
        $this->redis->connect($config["host"], $config["port"]);
        if (isset($config['auth']))  $this->redis->auth($config["auth"]);
    }

    public function rateLimitSimple($hash, $expire) {
        $current = $this->redis->get($hash);
        if (false === $current) {
            $this->redis->incr($hash);
            return $this->redis->expire($hash, intval($expire));
        }
        return false;
    }

    public function rateLimitCounter($hash, $max, $expire) {
        $current = $this->redis->get($hash);
        if (($current != NULL) && ($current >= $max)) {
            return 1;
        } else {
            $this->redis->incr($hash);
            return $this->redis->expire($hash, intval($expire));
        }
        return false;
    }
}

