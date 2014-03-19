<?php
namespace RtLmtr;

class RtLmtr {
    protected $redis; // Redis object instance
    public function __construct(array $config = array()) {
        $this->redis = new \Redis();
        $this->redis->connect($config["host"], $config["port"]);
        if (isset($config['auth']))  $this->redis->auth($config["auth"]);
    }

    public function rateLimitSimple($hash, $expire) {
        $hash = "smpl_" . $hash;
        $current = $this->redis->get($hash);
        if (FALSE === $current) {
            $this->redis->incr($hash);
            $this->redis->expire($hash, intval($expire));
            return 0;
        }
        return 1;
    }

    public function rateLimitCounter($hash, $max, $expire) {
        $hash = "cntr_" . $hash;
        $current = $this->redis->get($hash);
        if (($current != NULL) && ($current > $max)) {
            return 1;
        } else {
            $this->redis->incr($hash);
            $this->redis->expire($hash, intval($expire));
            return 0;
        }
        return 1;
    }
}

