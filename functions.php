<?php

function search($needle, $heap){
	$searchneedle=preg_replace('/[^a-z\d]+/i', '',strtoupper($needle));
	$result=array();
	foreach($heap as $row){
		$rcheck = preg_replace('/[^a-z\d]+/i', '',strtoupper($row[0]));
		similar_text($rcheck, $searchneedle, $percent);
		if($percent > 80){	
	                $result[] = array($row[0], $percent);
		}
		
	}
if(empty($result)){
	$result[]=array($needle, 0);
}
arsort($result);
foreach($result as $row){
//	echo print_r($row) ." <br />";
}
return $result;



}

?>
