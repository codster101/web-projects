import { Grid } from "./grid.js";
import { Clock } from "./clock.js";

let grid = new Grid();
let clock = new Clock(grid);

const start_stop_button = document.getElementById("start_stop");
start_stop_button.addEventListener("click", clock.stop);

console.log(grid);
window.addEventListener("load", grid.draw);

clock.run();

