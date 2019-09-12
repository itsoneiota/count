<?php
namespace itsoneiota\count;
/**
 * Tests for MockStatsD.
 *
 **/
class MockStatsDTest extends \PHPUnit\Framework\TestCase {

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

    /**
     * It should merge the UDP payload together into 1 string
     * @test
     */
    public function canBuildUDPPayload() {
        $payload = ["foo" => "-1|1" , "bar" => "1|-1" ];
        $response = $this->sut->buildWritePayload($payload);
        $this->assertEquals( "foo:-1|1\nbar:1|-1" , $response);
    }

    public function testCanAddCounterTags()
    {
        $payload = ["foo" => "-1|1", "bar" => "1|-1"];
        $tagString = "|#tagName:value";
        $response = $this->sut->buildWritePayload($payload, $tagString);
        $this->assertSame("foo:-1|1|#tagName:value\nbar:1|-1|#tagName:value", $response);
    }

    public function testCanBuildTagPayload()
    {
        $tags = [
            "tagName" => 'value1',
            "tagName2" => "value2",
            "tagName3" => 3,
        ];
        $result = $this->sut->buildTagsPayload($tags);
        $this->assertSame("|#tagName:value1,tagName2:value2,tagName3:3", $result);
    }

}
