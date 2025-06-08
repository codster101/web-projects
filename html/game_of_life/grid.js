import { Square } from "./square.js";

export function Grid() {
	const canvas = document.getElementById("canvas");
	const ctx = canvas.getContext("2d");
	canvas.addEventListener("click", (event) => select_square(event.offsetX, event.offsetY));

	// Number of squares in the grid
	const width = 150;
	const height = 75;
	const gap = 2;

	// Makes canvas fullscreen and determines size of squares based on the number that should be created
	// Gets the total width/height without the gap space then divides by the number of squares wide/tall
	canvas.width = window.innerWidth;
	canvas.height = window.innerHeight;
	let square_width = (canvas.width - (gap * (width + 1))) / width;
	let square_height = (canvas.height - (gap * (height + 1))) / height;
	//console.log((square_width + gap) + " : " + (square_height + gap));

	//let alter = true;
	let squares = Array.from(Array(height), () => new Array(width));
	for (let i = 0; i < height; i++) {
		for (let j = 0; j < width; j++) {
			squares[i][j] = new Square(false, square_width, square_height);
		}
	}

	function indexes_to_coords(w, h) {

		let x = square_width * w + gap * (w + 1);
		let y = square_height * h + gap * (h + 1);

		return [x, y];
	}

	function coords_to_indexes(x, y) {
		let i = Math.floor(x / (square_width + gap));
		let j = Math.floor(y / (square_height + gap));
		return [i, j];
	}

	function draw() {
		//console.log("draw");
		ctx.fillStyle = "rgb(75, 75, 75)";
		ctx.fillRect(0, 0, canvas.width, canvas.height);

		ctx.fillStyle = "rgb(255 255 255)";
		for (let i = 0; i < height; i++) {
			for (let j = 0; j < width; j++) {
				const x = indexes_to_coords(j, i)[0];
				const y = indexes_to_coords(j, i)[1];
				squares[i][j].draw(ctx, x, y);
				// console.log(x + ", " + y);
			}
		}
	}

	function manage_population() {
		//console.log("manage pop");
		let new_squares = Array.from(Array(height), () => new Array(width));
		for (let i = 0; i < height; i++) {
			for (let j = 0; j < width; j++) {
				new_squares[i][j] = check_box(i, j);
			}
		}
		squares = new_squares;
	}

	function check_box(x, y) {
		//console.log("check box");
		let neighbors = 0;
		for (let i = -1; i <= 1; i++) {
			for (let j = -1; j <= 1; j++) {
				// Skip self
				if (i == 0 && j == 0) continue;

				// Ensure indices are valid and check if neighbor is alive
				if (x + i >= 0 && x + i < height && y + j >= 0 && y + j < width) {
					if (squares[x + i][y + j].get_life()) neighbors++;
				}
			}
		}
		//if (neighbors > 0) console.log("(" + x + ", " + y + "): " + neighbors + " ");

		let current = squares[x][y];
		//if (!current) {
		//console.log(x + ", " + y);
		//}
		//console.log("(" + x + ", " + y + "): " + neighbors);

		// Each live cell with 2 or 3 live neighbors survives
		if (current.get_life()) {

			if (neighbors == 2 || neighbors == 3) return new Square(true, square_width, square_height);

			return new Square(false, square_width, square_height);
		}

		// Each dead cell with exactly 3 live neighbors becomes alive
		if (neighbors == 3) return new Square(true, square_width, square_height);

		return new Square(false, square_width, square_height);
	}

	function select_square(x, y) {

		let w = coords_to_indexes(x, y)[0];
		let h = coords_to_indexes(x, y)[1];
		//console.log(squares[h][w]);
		squares[h][w].set_life(true);

		let drawX = indexes_to_coords(w, h)[0];
		let drawY = indexes_to_coords(w, h)[1];
		squares[h][w].draw(ctx, drawX, drawY);

	}

	return {
		draw,
		manage_population,
		select_square
	};

}
