<?php include('head.php') ?>

<div class="scroll_wrapper">
<?php include 'header.php'; ?>
<?php 


if($_GET["page"]){
	$page = $_GET["page"];
}else{
	$page = "projects";	
}



include($page . ".php");

?>

<?php include('footer.php') ?>
</div>



<?php include 'js/main.js' ?>

</body>

</html>
