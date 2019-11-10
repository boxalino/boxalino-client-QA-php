<?php

/**
* In this example, we make a simple search query, get the second page of search results and print their ids
*/

//include the Boxalino Client SDK php files
//require_once(__DIR__ . '/../vendor/autoload.php');
use com\boxalino\bxclient\v1\BxClient;
use com\boxalino\bxclient\v1\BxSearchRequest;

//$libPath = __DIR__ . '/../vendor/boxalino/boxalino-client-sdk-php/lib'; //path to the lib folder with the Boxalino Client SDK and PHP Thrift Client files
//BxClient::LOAD_CLASSES($libPath);

//required parameters you should set for this example to work
//$account = ""; // your account name
//$password = ""; // your account password
//$apiKey = ""; // your api key for the isDev flag
//$apiSecret = ""; // your api secret for isDev flag
$domain = ""; // your web-site domain (e.g.: www.abc.com)
$logs = array(); //optional, just used here in example to collect logs
$isDev = false;
$host = isset($host) ? $host : "main.bx-cloud.com";

//Create the Boxalino Client SDK instance
//N.B.: you should not create several instances of BxClient on the same page, make sure to save it in a static variable and to re-use it.
$bxClient = new BxClient($account, $password, $domain, $isDev, $host);
$bxClient->setApiKey($apiKey);
$bxClient->setApiKey($apiSecret);
if(isset($timeout)) {
    $bxClient->setCurlTimeout($timeout);
}
try {
	$language = "en"; // a valid language code (e.g.: "en", "fr", "de", "it", ...)
	$queryText = "watch"; // a search query
	$hitCount = 5; //a maximum number of search result to return in one page
	$offset = 5; //the offset to start the page with (if = hitcount ==> page 2)
	
	//create search request
	$bxRequest = new BxSearchRequest($language, $queryText, $hitCount);
	
	//set an offset for the returned search results (start at position provided)
	$bxRequest->setOffset($offset);
	
	//add the request
	$bxClient->addRequest($bxRequest);

    //setting profile and session for
    $bxClient->setSessionAndProfile(basename(__FILE__, '.php'), $password);
	
	//make the query to Boxalino server and get back the response for all requests
	$bxResponse = $bxClient->getResponse();
	
	//loop on the search response hit ids and print them
	foreach($bxResponse->getHitIds() as $i => $id) {
		$logs[] = "$i: returned id $id";
	}

	if(!isset($print) || $print){
		echo implode("<br>", $logs);
	}
	
} catch(\Exception $e) {
	
	//be careful not to print the error message on your publish web-site as sensitive information like credentials might be indicated for debug purposes
	$exception = $e->getMessage();
	if(!isset($print) || $print){
		echo $exception;
	}
}
