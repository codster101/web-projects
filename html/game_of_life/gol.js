import { Grid } from "./grid.js";
import { Clock } from "./clock.js";

let grid = new Grid();
let clock = new Clock(grid);

const start_button = document.getElementById("start_button");
const stop_button = document.getElementById("stop_button");
//function cycle() {
//grid.manage_population();
//grid.draw();
//}
start_button.addEventListener("click", clock.run);
stop_button.addEventListener("click", clock.stop);

console.log(grid);
window.addEventListener("load", grid.draw);
//clock.run();

