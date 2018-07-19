// assets/js/app.js
require('../css/app.scss');

// ...rest of JavaScript code here

// loads the jquery package from node_modules
// const $ = require('jquery');

// import the function from console.js (the .js extension is optional)
// ./ (or ../) means to look for a local file
var mysole = require('./console');

// starts
$(document).ready(function() {
  // welcome message
  console.log(mysole('visitor'));

  // init MDB
  $('body').bootstrapMaterialDesign();
});