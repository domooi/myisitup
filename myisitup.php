<?php

$command = $_POST['command'];
$domain = $_POST['text'];
$token = $_POST['token'];

if($token != '9d8G7KD7taYIHDCFkUJJAPDS'){
	$msg = "The token for the slash command doesn't match. Check your script and try again";
	die($msg);
	echo $msg;
}

$user_agent = "IsitupForSlack/1.0 (https://github.com/mccreath/istiupforslack; mccreath@gmail.com)";

$url_to_check = "https://isitup.org/".$domain.".json";

$ch = curl_init($url_to_check);

curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$ch_response = curl_exec($ch);
curl_close($ch);

$response_array = json_decode($ch_response, TRUE);

if($ch_response === FALSE){
	$reply = ":eggplant: Ironically, isitup isn't up.";
} else {
		if ($response_array['status_code'] == 1){
    	$reply = ":thumbsup: Good news! *<http://".$response_array["domain"]."|".$response_array["domain"].">* is up!";
		
		} else if ($response_array['status_code'] == 2){
    	$reply = ":disappointed: Oh no! *<http://".$response_array["domain"]."|".$response_array["domain"].">* is down!";
		
		} else if($response_array['status_code'] == 3){
    	$reply  = ":interrobang: *".$domain."* does not appear to be a valid domain. ";
    	$reply .= "Please enter both the domain name AND suffix (ex: amazon.com or whitehouse.gov).";
}

echo $reply;

?>