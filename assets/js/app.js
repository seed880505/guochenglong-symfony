// assets/js/app.js
require('../css/app.scss');

// ...rest of JavaScript code here

// import the function from console.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var misc = require('./misc');

// loads the jquery package from node_modules
require('jquery');

// popper.js as global variable
global.Popper = require('popper.js').default;

// material design bootstrap
require('bootstrap-material-design/dist/js/bootstrap-material-design.min');

// starts
$(document).ready(function () {
  // welcome message
  console.log(misc.myConsole('visitor'));

  // init MDB
  $('body').bootstrapMaterialDesign();

  // init bootstrap tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // init music
  misc.initMusic('music-play');
});