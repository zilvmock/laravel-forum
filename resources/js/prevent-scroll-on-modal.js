// noinspection JSUnusedLocalSymbols

window.onload = function () {
  $(".modal").bind(
    "mousedown.prev DOMMouseScroll.prev mousewheel.prev keydown.prev keyup.prev",
    function (e, d) {
      e.preventDefault();
    }
  );
};
