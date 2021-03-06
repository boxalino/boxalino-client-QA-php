<?php

/**
* In this example, we make a simple search autocomplete query, get the textual search suggestions and the item suggestions for each textual suggestion and globally
*/

//include the Boxalino Client SDK php files
//require_once(__DIR__ . '/../vendor/autoload.php');
use com\boxalino\bxclient\v1\BxClient;
use com\boxalino\bxclient\v1\BxAutocompleteRequest;

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
	$queryText = "whit"; // a search query to be completed
	$textualSuggestionsHitCount = 10; //a maximum number of search textual suggestions to return in one page
	$fieldNames = array('title'); //return the title for each item returned (globally and per textual suggestion) - IMPORTANT: you need to put "products_" as a prefix to your field name except for standard fields: "title", "body", "discountedPrice", "standardPrice"

	//create search request
	$bxRequest = new BxAutocompleteRequest($language, $queryText, $textualSuggestionsHitCount);
	
	//set the fields to be returned for each item in the response
	$bxRequest->getBxSearchRequest()->setReturnFields($fieldNames);
	
	//set the request
	$bxClient->setAutocompleteRequest($bxRequest);

    //setting profile and session for
    $bxClient->setSessionAndProfile(basename(__FILE__, '.php'), $password);

	//make the query to Boxalino server and get back the response for all requests
	$bxAutocompleteResponse = $bxClient->getAutocompleteResponse();

	//loop on the search response hit ids and print them
	$logs[] = "textual suggestions for \"$queryText\":<br>";
	foreach($bxAutocompleteResponse->getTextualSuggestions() as $suggestion) {
		$logs[] = "<div style=\"border:1px solid; padding:10px; margin:10px\">";
		$logs[] = "<h3>$suggestion</b></h3>";

		$logs[] = "item suggestions for suggestion \"$suggestion\":<br>";
		//loop on the search response hit ids and print them
		foreach($bxAutocompleteResponse->getBxSearchResponse($suggestion)->getHitFieldValues($fieldNames) as $id => $fieldValueMap) {
			$logs[] = "<div>$id";
			foreach($fieldValueMap as $fieldName => $fieldValues) {
				$logs[] = " - $fieldName: " . implode(',', $fieldValues) . "";
			}
			$logs[] = "</div>";
		}
		$logs[] = "</div>";
	}

	$logs[] = "global item suggestions for \"$queryText\":<br>";
	//loop on the search response hit ids and print them
	foreach($bxAutocompleteResponse->getBxSearchResponse()->getHitFieldValues($fieldNames) as $id => $fieldValueMap) {
		$item = "$id";
		foreach($fieldValueMap as $fieldName => $fieldValues) {
			$item .= " - $fieldName: " . implode(',', $fieldValues) . "<br>";
		}
		$logs[]= $item;
	}
	if(!isset($print) || $print){
		echo implode('', $logs);
	}

} catch(\Exception $e) {
	
	//be careful not to print the error message on your publish web-site as sensitive information like credentials might be indicated for debug purposes
	$exception = $e->getMessage();
	if(!isset($print) || $print){
		echo $exception;
	}
}
