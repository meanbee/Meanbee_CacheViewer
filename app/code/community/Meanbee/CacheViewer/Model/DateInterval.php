<?php
/**
 * Class Meanbee_CacheViewer_Model_DateInterval
 *
 * @see http://www.php.net/manual/en/dateinterval.format.php#102271
 */
class Meanbee_CacheViewer_Model_DateInterval extends DateInterval {

    /**
     * @param $seconds
     * @return Meanbee_CacheViewer_Model_DateInterval
     */
    public static function createFromSeconds($seconds)
    {
        if ($seconds > 0) {
            return new self("PT{$seconds}S");
        } else {
            return new self("PT0S");
        }
    }

    /**
     * @return int
     */
    public function to_seconds()
    {
        return ($this->y * 365 * 24 * 60 * 60) +
        ($this->m * 30 * 24 * 60 * 60) +
        ($this->d * 24 * 60 * 60) +
        ($this->h * 60 * 60) +
        ($this->i * 60) +
        $this->s;
    }

    /**
     * Recalculate interval parts
     */
    public function recalculate()
    {
        $seconds = $this->to_seconds();
        $this->y = floor($seconds/60/60/24/365);
        $seconds -= $this->y * 31536000;
        $this->m = floor($seconds/60/60/24/30);
        $seconds -= $this->m * 2592000;
        $this->d = floor($seconds/60/60/24);
        $seconds -= $this->d * 86400;
        $this->h = floor($seconds/60/60);
        $seconds -= $this->h * 3600;
        $this->i = floor($seconds/60);
        $seconds -= $this->i * 60;
        $this->s = $seconds;
    }
}
