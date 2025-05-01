import { Square } from "./square.js";

export function Grid() {
	const canvas = document.getElementById("canvas");
	const ctx = canvas.getContext("2d");

	// Number of squares in the grid
	const width = 150;
	const height = 75;
	const gap = 2;

	let alter = true;
	const squares = Array.from(Array(height), () => {
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

	function managePopulation() {

		squares = squares.map(x => check_box(x));

	}

	function check_box(box) {
		let neighbors = 0;
		for (let i = -1; i <= 1; i++) {
			for (let j = -1; j <= 1; j++) {
				if (i == 0 && j == 0) continue;

				// if(
			}
		}

	}

	return {
		draw,
		managePopulation
	};
}
