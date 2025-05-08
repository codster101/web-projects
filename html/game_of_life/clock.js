export function Clock(g) {
	let clock_on = true;
	let clock_cycle = 1	// Length of a cycle in seconds
	let last_cycle_time = Date.now();

	function run() {
		while (clock_on) {
			// Run cycle events if sufficient time has passed since the last cycle
			let diff = (last_cycle_time - Date.now()) / 1000;
			if (diff > clock_cycle) {
				cycle_events();
				last_cycle_time = Date.now();
			}
		}
	}

	function cycle_events() {
		g.manage_population();
	}

	function stop() { clock_on = false; }

	return {
		run,
		stop
	};
}
