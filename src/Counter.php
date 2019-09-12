<?php
namespace itsoneiota\count;

/**
 * Static registry for a StatsD instance.
 */
class Counter {

    protected static $instance;

    public static function setInstance(StatsD $instance=NULL) {
        self::$instance = $instance;
    }

    public static function getInstance() {
        return self::$instance;
    }

    public static function updateStats($stats, $delta=1, $sampleRate=1, $metric='c', $tags = []) {
        if (is_null(self::$instance)) {
            return;
        }
        self::$instance->updateStats($stats, $delta, $sampleRate, $metric, $tags);
    }

	/**
     * Sets one or more timing values
     *
     * @param string|array $stats The metric(s) to set.
     * @param float $time The elapsed time (ms) to log
     * @param array $tags list of tags to be applied to the metric
     **/
    public static function timing($stats, $time, $tags =[]) {
        self::updateStats($stats, $time, 1, 'ms', $tags);
    }

    /**
     * Sets one or more gauges to a value
     *
     * @param string|array $stats The metric(s) to set.
     * @param float $value The value for the stats.
     * @param array $tags list of tags to be applied to the metric
     **/
    public static function gauge($stats, $value, $tags =[]) {
        self::updateStats($stats, $value, 1, 'g', $tags);
    }

    /**
     * A "Set" is a count of unique events.
     * This data type acts like a counter, but supports counting
     * of unique occurences of values between flushes. The backend
     * receives the number of unique events that happened since
     * the last flush.
     *
     * The reference use case involved tracking the number of active
     * and logged in users by sending the current userId of a user
     * with each request with a key of "uniques" (or similar).
     *
     * @param string|array $stats The metric(s) to set.
     * @param array $tags list of tags to be applied to the metric
     * @param float $value The value for the stats.
     **/
    public static function set($stats, $value, $tags =[]) {
        self::updateStats($stats, $value, 1, 's', $tags);
    }

    /**
     * Increments one or more stats counters
     *
     * @param string|array $stats The metric(s) to increment.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @param array $tags list of tags to be applied to the metric
     * @return boolean
     **/
    public static function increment($stats, $sampleRate=1, $tags =[]) {
        self::updateStats($stats, 1, $sampleRate, 'c', $tags);
    }

    /**
     * Decrements one or more stats counters.
     *
     * @param string|array $stats The metric(s) to decrement.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @param array $tags list of tags to be applied to the metric
     * @return boolean
     **/
    public static function decrement($stats, $sampleRate=1, $tags =[]) {
        self::updateStats($stats, -1, $sampleRate, 'c', $tags);
    }
}
