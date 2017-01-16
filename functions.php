<?php

function search($needle, $heap){
	$searchneedle=str_replace('&','AND', $needle);
	$searchneedle=preg_replace('/[^a-z\d]+/i', '',strtoupper($searchneedle));
	$result=array();
	foreach($heap as $row){
		$rcheck = str_replace('&', 'AND', $rcheck);
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
