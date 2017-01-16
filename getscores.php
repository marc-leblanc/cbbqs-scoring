<?php 
	include('functions.php');
	$cbbqsMems = "cache/members.csv";
?>
<html>
<head>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>

function changeContest() {
	newContest = document.getElementById('contest').value;
	$('.contest').text(newContest);
}

</script>

</head>
<body>
<?php

// The setup - load simplehtml dom lib, intitialize variables

	include('simplehtmldom/simple_html_dom.php'); // include simplehtmldom library 
	$curl="";
	$curl=$_POST['curl'];
	// Create dom from cache files
	$html = file_get_html($curl);
	$title= $html->find('h1',0);
	$scoretable = $html->find('table',0); // Load the fist table from the results page into score table. The first table is always the OVERALL Scores. This will change if the KCBS changes their result page format
	$locationDate= $html->getElementById('event_subhead'); 
	$location = $html->getElementById('event_subhead')->childNodes(0);
	$date =  $html->getElementById('event_subhead')->childNodes(1);

	$members = array_map('str_getcsv', file($cbbqsMems));





// The DO STUFF part of this awesome script 

$location=explode(PHP_EOL ,$locationDate->plaintext)[0];
$date=explode(PHP_EOL, $locationDate->plaintext)[1];

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


foreach($csv as $row){
	if($row[0] !=''){
                $match = search($row[1],$members);
//		$scoreOut.= $row[0] .',' .$row[1] .',<span class="contest">' .$title->plaintext ."</span><br />";
		$scoreOut .='<div class="row"><div class="col">' .$row[0] .'</div><div class="col">' .$match[0] .'</div>'
		           .'<div class="col contest">' .$title->plaintext .'</div>';

			    //echo  print_r(search($row[1],$members));
//			    echo $match[1];
		// figure out team loop.
		if($match[1]==100){ 
			$matchout="100 % Match";
		}else{
			$matchout=" ";
		}
		$scoreOut .= '<div class="col">'. $matchout  .'</div></div>';
		$numteams=$row[0];
		
	}

}


// Ublock of download CSV is active	fclose($fp);




// Output

echo "<span class='label'>Contest Name:</span><input id='contest' type='text' value='$title->plaintext'> <a href='#' id='updateContest' onclick='changeContest()'>Update Contest Name</a><br /><br />";
echo "<span class='label'>Location:</span><input type='text' value='" .trim($location) ."'> <br /> <span class='label'>Date:</span> <input tpye='text' value='" .trim($date). "'> <br/>";
echo "<span class='label'>Number of teams:</span><input type='text' value='$numteams'><br /><br />";
?>
<div class="table">
<div class="row th">
  <div class="col">Place</div>
  <div class="col">Team Name</div>
  <div class="col">Contest Name</div>
  <div class="col">Interventions</div>
</div>

<?php echo $scoreOut; ?>
		

</div>

</body>
</html>
