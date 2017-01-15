<?php
	include('simplehtmldom/simple_html_dom.php'); // include simplehtmldom library 

	// Create dom from cache files
	$html = file_get_html('cache/ointoberfest-bbq-cookoff');
//        echo $html;	
	$scoretable = $html->find('table',0);
	echo $scoretable;
/****************
Use following lines if you want to generate a downloadable CSV file. Useful for troubleshooting.
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename=sample.csv');
	$fp = fopen("php://output", "w");

****************/
$csv=array();
foreach($scoretable->find('tr') as $element){
    $td = array();
    foreach( $element->find('td') as $row){
        $td [] = $row->plaintext;
    }
    $csv[] = $td;
}

echo "<pre>" .print_r($csv) ."</pre>";

// Ublock of download CSV is active	fclose($fp);

function get_current_scores(){
  return("not implemented yet");	

}	


?>
