<?PHP
// pull map for zip + country

$zip_map = get_user_meta($auth->ID ,'zip' ,TRUE);
$co_map = get_user_meta($auth->ID ,'country' ,TRUE);

$naam = $zip_map . " ". $co_map;
if (strlen($zip_map) > 3 && strlen($co_map) > 3)
	{
	// GEO CODER GOOGLE
	$url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($naam) . "&sensor=false";
	//echo $url;
	$xml = simplexml_load_file($url);
		if ($xml->status[0] == "OK" && $patch != '1')
			{
			$lat = $xml->result[0]->geometry->location->lat;
			$lng = $xml->result[0]->geometry->location->lng;				
			}
	$mapdata[0] = array("$lat","$lng","$naam");

	if (empty($lat))
		{
		// try yahoo
		$url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($naam) . "&sensor=false";
		$url = "http://where.yahooapis.com/geocode?q=".urlencode($naam) . "%20nederland&locale=nl_NL&appid=J5K7dk36";
		//echo $url;
		$xml = simplexml_load_file($url);
			$lat = $xml->Result[0]->latitude;
			$lng = $xml->Result[0]->longitude;
		$mapdata[0] = array("$lat","$lng","$naam");
		}
	echo "<br>";
	?>	
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<div id="map_div" style="width: 90%; height: 300px;margin:5px auto"></div>			
						<script>
						  var map;
						  var markers = [];

						  function initialize() {
							var zippy = new google.maps.LatLng(<?PHP echo $lat.",".$lng ?>);
							var mapOptions = {
							  zoom: 11,
							  center: zippy,
							  mapTypeId: google.maps.MapTypeId.TERRAIN
							};
							map = new google.maps.Map(document.getElementById('map_div'),
								mapOptions);

							google.maps.event.addListener(map, 'click', function(event) {
							  addMarker(event.latLng);
							});
							
							marker = new google.maps.Marker({
							  position: zippy,
							  map: map
							});
							
						  }

						  google.maps.event.addDomListener(window, 'load', initialize);
						</script>
	<?PHP	
		
	}
else
	{
	echo "<br>";
	_e('I could not produce a map because the user did not provide data to geocode his or her location', 'wpfrl');
	}