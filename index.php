<?php
if(isset($_REQUEST['ip'])) {
$me = trim($_REQUEST['ip']);	
}else {
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$me = get_client_ip();
}
$ip= '&ip='.$me;
$apiBase= 'https://api.ipinfodb.com/v3/ip-country/?';
$apiKey= 'key=ef58a012edfa13c9eb111228d9a587b88f14d7a5bccec95d86bd4aad617ae2a2';//get an api key here http://ipinfodb.com/ip_location_api.php
$call = $apiBase.$apiKey.$ip.'&format=xml';

// Defining the basic cURL function
function curl($url) {
    $ch = curl_init();  // Initialising cURL
    curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
    $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
    curl_close($ch);    // Closing cURL
    return $data;   // Returning the data from the function
 }
 $scraped = curl($call); // calling the cURL function

 $html = ""; // creating the html "pallet"
 $xml = simplexml_load_string($scraped); //parse the xml data
 $item = $xml->countryCode; // pull the country code out of the xml data
 $item = strtolower($item); //convert the response to all lower case letters
 	# build the html to display
	$html.= '<div align="center">
			  You are visiting from: <img src="CountryFlags/gif/'.$item.'.gif" height="11px" class="img-flag" alt="image not found"/>
			 </div>';
	echo $html; //display the html

$strip1= str_replace("OK" ,"",$scraped); // strip the "OK" response
$strip2= str_replace($me, "", $strip1); // strip users IP address from the response

echo '<hr>'; // optional

?>