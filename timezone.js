$(document).ready(function () {
  var offset = new Date().getTimezoneOffset();

  var timestamp = new Date().getTime();

  /*Convert our time to universal Time coordinated / Universal Coordinated time */

  var utc_timestamp = timestamp + 60000 * offset;

  //Passing the values to hidden inputs upon form submission
  $("#submit").click(function (event) {
    $("#utc_timestamp").val(utc_timestamp);
    $("#time_zone_offset").val(offset);
  });
});
