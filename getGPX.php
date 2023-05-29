<?php
$listOfPathsGPX = './js/map/gpx/';
//print_r($listOfPathsGPX);
$listOfFileNamesGPX = scandir($listOfPathsGPX);
$listOfFileNamesGPX = array_slice($listOfFileNamesGPX, 2);

$tracksGPX = array();
$tmplatlonPDOP = array();


foreach ($listOfFileNamesGPX as $fileGPX) {
	$GNSS= 'no gnss';
	$nameTrack = 'no title';
	$nameTrack = $fileGPX;

	$gpx = simplexml_load_file($listOfPathsGPX . $fileGPX);

	if($gpx->GNSS)
	{
		$GNSS = ((array)$gpx->GNSS)[0];
	}

	if ($gpx->title)
	{
		$nameTrack = ((array)$gpx->title)[0];
		if ($tracksGPX[$nameTrack]){
			if ($tracksGPX[$nameTrack][$GNSS]){
				$nameTrack = $fileGPX;
			}
		}
	}

		foreach($gpx->trk->trkseg as $seg){
			foreach($seg->trkpt as $pt){
				$time = (array)$pt->time;
				if($pt["lat"] && $pt["lon"]) {
					$pdop = 0;
					if (!$pt->PDOP){
						$pdop = 6;
					}else{
						$pdop = floatval($pt->PDOP);
					}
					//$time[0]
					$tmplatlonPDOP[] = [floatval($pt["lat"]), floatval($pt["lon"]), $pdop];
				}
			}
		}

	$tracksGPX[$nameTrack][$GNSS] = [];
	$tracksGPX[$nameTrack][$GNSS]['points'] = $tmplatlonPDOP;

	$tmplatlonPDOP = array();
}
unset($gpx);
echo json_encode($tracksGPX);

