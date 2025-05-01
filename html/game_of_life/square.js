export function Square(alive = false) {
	const is_alive = alive;

	function setLife(alive) {
		is_alive = alive;
	}

	function draw(ctx, x, y, width, height) {
		if (is_alive) {
			ctx.fillStyle = "rgb(255 255 255)";
		} else {
			ctx.fillStyle = "rgb(0 0 0)";
		}
		ctx.fillRect(x, y, width, height);
	}

	return {
		setLife,
		draw
	}
}
