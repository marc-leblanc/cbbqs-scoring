<?php

	include('functions.php'); //include main functions and libraries
	$auto=$_GET["auto";

	if($auto=="y"){
		get_current_scores();
		die();
	}
?>


	<form name="getScoresByContest"><input type="textarea" name="contestName" placeholder="Name as copy and pasted from KCBS results page"><submit></form>
