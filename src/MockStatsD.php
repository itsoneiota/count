<?php
namespace itsoneiota\count;
/**
 * Mock version of StatsD.
 *
 * Allows easy querying of metrics recorded in tests.
 * Currently only supports incrementing/decrementing counters.
 **/
class MockStatsD extends StatsD {

	protected $metrics = [];

    function __construct() {}

    public function getCounter($name) {
    	return array_key_exists($name, $this->metrics) ? $this->metrics[$name] : 0;
    }

    public function timing($stats, $time) {/*Noop*/}
    public function gauge($stats, $value) {/*Noop*/}
    public function set($stats, $value) {/*Noop*/}

    /**
     * Increments one or more stats counters
     *
     * @param string|array $stats The metric(s) to increment.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @return boolean
     **/
    public function increment($stats, $sampleRate=1) {
    	if (!array_key_exists($stats, $this->metrics)) {
    		$this->metrics[$stats] = 0;
    	}
        $this->metrics[$stats] += 1;
    }

    /**
     * Decrements one or more stats counters.
     *
     * @param string|array $stats The metric(s) to decrement.
     * @param float|1 $sampleRate the rate (0-1) for sampling.
     * @return boolean
     **/
    public function decrement($stats, $sampleRate=1) {
    	if (!array_key_exists($stats, $this->metrics)) {
    		$this->metrics[$stats] = 0;
    	}
        $this->metrics[$stats] -= 1;
    }
}
