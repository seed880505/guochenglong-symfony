// assets/js/misc.js
module.exports = {
  myConsole: function (name) {
    return `Yo yo ${name} - welcome to guochenglong.com!`;
  },

  initMusic: function (dom_id) {
    var $control = $(`#${dom_id}`);

    $control.click(function () {
      var $player = $('#music-src')[0], cls = 'fa-spin';

      if ($control.hasClass(cls)) {
        $control.removeClass(cls);
        $player.pause();

      } else {
        $control.addClass(cls);
        $player.play();
      }
    });
  }
};