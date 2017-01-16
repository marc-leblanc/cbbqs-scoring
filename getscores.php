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

function changeTeam(teamplace, newTeam){
	tid= "#team" + teamplace
	$(tid).text(newTeam);
}
	
</script>

</head>
<body>
<?php

// The setup - load simplehtml dom lib, intitialize variables

	include('simplehtmldom/simple_html_dom.php'); // include simplehtmldom library 
	$curl="";
	$curl=$_POST['curl']; //get contest url from POST var

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
		if(!strcmp($row[1], 'BLACK HART BBQ')){
			echo $match;
		}

		$place = $row[0];
		if($match[0][1] == 100){
			$team = $match[0][0];
			$intervention = "<span class='found'>100% Match</span>\n";
		}elseif($match[0][1] == 0){
			$team = $row[1];
			$intervention = "<span class='notfound'>Not found</span>\n";
		}else{
			$team=$row[1];
			$intervention =''; //reset intervention variable
			foreach($match as $searchresult){
			   $intervention .= "<span class='hits'> $searchresult[0]</span> - " .round($searchresult[1],1) ." % Match - <a onclick='changeTeam($place, \"$searchresult[0]\")'>Use</a><br/>\n";
			}

		}

		$scoreOut .='<div class="row"><div class="col">' .$place .'</div><div class="col"><span id="team' .$place .'">' .$team .'</span></div>'
		           .'<div class="col contest">' .$title->plaintext .'</div>';




		$scoreOut .= '<div class="col">'. $intervention  .'</div></div>';
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
