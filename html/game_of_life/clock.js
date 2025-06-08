export function Clock(g, t) {
	let clock_cycle = t;	// Length of a cycle in seconds
	let interval_id = 0;

	function run() {
		interval_id = setInterval(cycle_events, clock_cycle);
	}

	function cycle_events() {
		g.manage_population();
		g.draw();
	}

	function stop() {
		clearInterval(interval_id);
	}

	return {
		run,
		stop
	};
}
