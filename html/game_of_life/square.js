export function Square(alive = false, w, h) {
	let is_alive = alive;

	const width = w;
	const height = h;

	function set_life(alive) {
		is_alive = alive;
	}

	function get_life() { return is_alive; }

	function draw(ctx, x, y) {
		if (is_alive) {
			ctx.fillStyle = "rgb(255 255 255)";
		} else {
			ctx.fillStyle = "rgb(0 0 0)";
		}
		ctx.fillRect(x, y, width, height);
	}

	return {
		set_life,
		get_life,
		draw
	}
}
