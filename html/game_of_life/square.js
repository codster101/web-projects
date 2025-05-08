export function Square(alive = false) {
	const is_alive = alive;

	function set_life(alive) {
		is_alive = alive;
	}

	function get_life() { return is_alive; }

	function draw(ctx, x, y, width, height) {
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
