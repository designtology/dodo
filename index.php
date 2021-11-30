<?php include('head.php') ?>

<div class="background_scroll_wrapper">



  	<div class="scroll_wrapper">

<?php 


if($_GET["page"]){
	$page = $_GET["page"];
}else{
	$page = "projects";	
}



include($page . ".php");

?>

	</div>
</div>

<?php include('footer.php') ?>
