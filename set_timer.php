<?php
include "database.php";
$id = $_REQUEST['id'];

include('secondstohuman.php');
include('calc_time_diff.php');

$worked_hours = calc_time_diff($id);


if($_REQUEST['action'] != "auto"){
    $timestamp = time();
    $sql = "INSERT INTO timetable (position_id,start_date) VALUES ('{$_REQUEST[id]}','{$timestamp}')";

    if (mysqli_query($conn, $sql)) {}
}

// THIS SHOULD NOT REQUEST COMPANY OR PROJECT NAMES RATHER THAN GET IT FROM SQL QUERY

?>
<div class="timer_large">
	<div class="timer_company"><b><?php echo $_REQUEST['company']; ?></b></div>
    <div class="timer_company"><b><?php echo $_REQUEST['project']; ?></b></div>
    <div id="start_date" data-time="<?php echo $worked_hours; ?>">Bereits geleistet: <b><?php echo seconds2human($worked_hours); ?></b></div>
    <div class="timer_display_desc">Aktuelle Zeit:</div>
	<div class="timer_display" id="stopWatch">00:00:00:01</div>
	<btn id="stop_timer">Stop</btn>
</div>
<script>

var counter = null;
var time = 1;
var date = new Date();
var start_date = $("#start_date").attr("data-time");

function start() {
    counter = setInterval(function () {
        if(start_date)
            var temp = start_date + time;
        else
            var temp = time;

        $("#stopWatch").html(
            secondsToDhms(parseInt(parseInt(time))));
        console.log(start_date);
        time++;
    }, 1000);
}


$("[id^=stop_timer]").click(function () {
	var position_id = <?php echo $_REQUEST['id']; ?>;
$.ajax({
    type: 'POST',
    url: 'write_time.php',
    data: {action: start,
    	id: position_id},
    success: function (data) {
      $("#timer_container").empty();
      console.log(data);
      clearInterval(counter);
      counter = null;
      //write current date as stop date in database in seconds

      $("[id^=start_timer]").css('display','block');
      $("[id^=stop_timer]").css('display','none');

      $("#start_timer_"+position_id).attr("data-action","");
    }
});
});

start();

</script>