$("#payer").on("change", function () {
  var $sel = $(this).find(":selected");
  if ($sel.length <= 7) {
    $sel.addClass("selected");
    $(this).find(":not(:selected)").removeClass("selected");
  } else $(this).find(":selected:not(.selected)").prop("selected", false);
});
