import '../css/packy.css';

// require jQuery normally
const $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;


const Highcharts = require('highcharts');
require('highcharts/modules/exporting')(Highcharts);

global.Highcharts = Highcharts;
