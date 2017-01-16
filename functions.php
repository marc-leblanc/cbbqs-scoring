<?php

function search($needle, $heap){
	$match=0;
	$tname='';
        $searchneedle= strtoupper(preg_replace('/\s+/', '',$needle));
//	echo $searchneedle ."<br />----------<br />";
//	return array(10,10);
	$result=array();
	$result[1]=0;
	$result[0]=$needle;
	foreach($heap as $row){
//		echo  strtoupper(preg_replace('/\s+/','',$row[0])) ."<br />";
		if(!strcmp($searchneedle,strtoupper(preg_replace('/\s+/','',$row[0])))){
			$result[0]= $row[0];
			$result[1]=100;
		}
		
	}
return $result;



}

?>
