<?php
namespace oneiota\count;
/**
 * Tests for MockStatsD.
 *
 **/
class MockStatsDTest extends \PHPUnit_Framework_TestCase {
	
	protected $sut;
	
	public function setUp() {
		$this->sut = new MockStatsD();
	}

	/**
	 * It should return 0 for an uninitialised counter.
	 * @test
	 */
	public function canReturnZeroForUninitialisedCounter() {
		$this->assertEquals(0, $this->sut->getCounter('nonExistent'));
	}

	/**
	 * It should increment a counter.
	 * @test
	 */
	public function canIncrement() {
		$this->sut->increment('foo');
		$this->sut->increment('foo');
		$this->sut->increment('foo');
		$this->assertEquals(3, $this->sut->getCounter('foo'));

		$this->sut->increment('bar');
		$this->sut->increment('bar');
		$this->assertEquals(2, $this->sut->getCounter('bar'));
	}

	/**
	 * It should decrement a counter.
	 * @test
	 */
	public function canDecrement() {
		$this->sut->decrement('foo');
		$this->assertEquals(-1, $this->sut->getCounter('foo'));

		$this->sut->increment('foo');
		$this->sut->increment('foo');
		$this->sut->increment('foo');
		$this->assertEquals(2, $this->sut->getCounter('foo'));

		$this->sut->decrement('foo');
		$this->assertEquals(1, $this->sut->getCounter('foo'));
	}

}