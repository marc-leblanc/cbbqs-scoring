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
		$rowcheck = strtoupper(preg_replace('/\s+/','',$row[0]));
		if(!strcmp($searchneedle,$rowcheck)){
			$result[0]= $row[0];
			$result[1]=100;
			echo "z";
		}elseif(!strcmp($searchneedle,preg_replace('\'','',$rowcheck))){
			$result[0]= $row[0];
                        $result[1]=100;
			echo "}" .$searchneedle .$rowcheck ."<br />";
		}elseif(!strcmp($searchneedle,preg_replace('\'s','',$rowcheck))){
                        $result[0]= $row[0];
                        $result[1]=100;
                }elseif(!strcmp($searchneedle,str_replace('&','AND', $rowcheck))){
			$result[0]= $row[0];
                        $result[1]=100;
		}
		
	}
return $result;



}

?>
