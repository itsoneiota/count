One iota Metrics Components
===========================
Background
----------
This a _very_ slightly modified version of Etsy's StatsD example for PHP. The `Counter` class provides a static registry (It's a singleton. Don't even start.) for `StatsD` instance, allowing it to be accessed from every nook and cranny of an application.

Installing
----------
This library is best installed using Composer. Include the generated Composer autoloader (usually vendor/autoload.php).

Configuring
-----------
The `StatsD` class has two constructor arguments, host and port.

Initialising
------------
The bare minimum you need to do is instantiate StatsD with your server settings and you're good to go.

To make sending metrics more accessible around your application, you can use the `Counter` static registry.

	$statsD = new StatsD($myHost, $myPort);
	Counter::setInstance($statsD);

	...

	Counter::increment('hits');

Testing Collaborators with `MockStatsD`
---------------------------------------
If you need to test that a class is sending statistics as you expect, you can create an instance of `MockStatsD`, which can report on the current value of counters being incremented/decremented. At present, `MockStatsD` can only report on counters.

	$statsD = new MockStatsD();
	Counter::setInstance($statsD);

	... test test test ...

	$fooCount = $statsD->getCounter('foo');