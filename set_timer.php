
// style fullscreen overlay timer with button to stop and current customer name and position

<div id="stopWatch"></div>
<div id="stop_timer">Stop</div>

<script>
var counter = null;
var time = 0;
var date = new Date();


function start() {
    counter = setInterval(function () {

    	// for when the site is reloaded the script gets start date from db and counts elapsed seconds
    	// get start date from database
    	//if row for $_REQUEST['id'] has no stop date but start date


	    //write current date as start date in database in seconds
	    // if there is no start date

    	// format date from db (if already started) and start timer from there on to show actual working time
        $("#stopWatch").html((secondsToDhms(date.getTime() / 1000 + time)));
        time++;
    }, 1000);

}

$("#stop_timer").click(function () {
	console.log('start: ' + date)
	console.log(secondsToDhms(time));
	console.log('stop: ' + new Date(date.setSeconds(date.getSeconds() + time)).toUTCString())	

	//write current date as stop date in database in seconds
});

start();

</script>

<?php
	echo $_REQUEST['id'];


?>