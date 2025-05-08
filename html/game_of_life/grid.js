import { Square } from "./square.js";

export function Grid() {
	const canvas = document.getElementById("canvas");
	const ctx = canvas.getContext("2d");

	// Number of squares in the grid
	const width = 150;
	const height = 75;
	const gap = 2;

	let alter = true;
	let squares = Array.from(Array(height), () => {
		alter = !alter;
		return new Array(width).fill(Square(alter));
	});

	function draw() {
		canvas.width = window.innerWidth;
		canvas.height = window.innerHeight;

		let square_width = (canvas.width - (gap * (width + 1))) / width;
		let square_height = (canvas.height - (gap * (height + 1))) / height;
		//let square_width = 100;
		//let square_height = 100;

		ctx.fillStyle = "rgb(75, 75, 75)";
		ctx.fillRect(0, 0, canvas.width, canvas.height);

		ctx.fillStyle = "rgb(255 255 255)";
		for (let i = 0; i < height; i++) {
			for (let j = 0; j < width; j++) {
				let x = square_width * j + gap * (j + 1);
				let y = square_height * i + gap * (i + 1);
				// ctx.fillRect(x, y, square_width, square_height);
				squares[i][j].draw(ctx, x, y, square_width, square_height);
				console.log(x + ", " + y);
			}
		}
	}

	function manage_population() {
		let new_squares = Array.from(Array(height), () => new Array(width));
		for (let i = 0; i <= height; i++) {
			for (let j = 0; j <= width; j++) {
				new_squares[i][j] = check_box(i, j);
			}
		}
		squares = new_squares;
	}

	function check_box(x, y) {
		let neighbors = 0;
		for (let i = -1; i <= 1; i++) {
			for (let j = -1; j <= 1; j++) {
				// Skip self
				if (i == 0 && j == 0) continue;

				// Ensure indices are valid and check if neighbor is alive
				if (x + i >= 0 && x + i < width && y + j >= 0 && y + j < height) {
					if (squares[x + i][y + j].is_alive()) neighbors++;
				}
			}
		}

		let current = squares[x][y];

		if (current.is_alive()) {

			if (neighbors == 2 || neighbors == 3) return new Square(true);

			return new Square(false);
		}

		if (current.is_alive() && neighbors == 3) return new Square(true);

		return new Square(false);
	}

	return {
		draw,
		manage_population
	};
}
