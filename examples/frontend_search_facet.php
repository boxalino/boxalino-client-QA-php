<?php

/**
* In this example, we make a simple search query, request a facet and get the search results and print the facet values and counter.
* We also implement a simple link logic so that if the user clicks on one of the facet values the page is reloaded with the results with this facet value selected.
*/

//include the Boxalino Client SDK php files
//require_once(__DIR__ . '/../vendor/autoload.php');
use com\boxalino\bxclient\v1\BxClient;
use com\boxalino\bxclient\v1\BxSearchRequest;
use com\boxalino\bxclient\v1\BxFacets;

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
	$queryText = "women"; // a search query
	$hitCount = 10; //a maximum number of search result to return in one page
	$facetField = "products_color"; //the field to consider in the filter - IMPORTANT: you need to put "products_" as a prefix to your field name except for standard fields: "title", "body", "discountedPrice", "standardPrice"
	$selectedValue = isset($_REQUEST['bx_' . $facetField]) ? $_REQUEST['bx_' . $facetField] : null;

	//create search request
	$bxRequest = new BxSearchRequest($language, $queryText, $hitCount);
	
	//set the fields to be returned for each item in the response
	$bxRequest->setReturnFields(array($facetField));
	
	//add a facert
	$facets = new BxFacets();
	$facets->addFacet($facetField, $selectedValue);
	$bxRequest->setFacets($facets);
	
	//add the request
	$bxClient->addRequest($bxRequest);

    //setting profile and session for running unit tests
    $bxClient->setSessionAndProfile(basename(__FILE__, '.php'), $password);
	
	//make the query to Boxalino server and get back the response for all requests
	$bxResponse = $bxClient->getResponse();

	//get the facet responses
	$facets = $bxResponse->getFacets();
	
	//loop on the search response hit ids and print them
	foreach($facets->getFacetValues($facetField) as $fieldValue) {
		$logs[] = "<a href=\"?bx_" . $facetField . "=" . $facets->getFacetValueParameterValue($facetField, $fieldValue) . "\">" . $facets->getFacetValueLabel($facetField, $fieldValue) . "</a> (" . $facets->getFacetValueCount($facetField, $fieldValue) . ")";
		if($facets->isFacetValueSelected($facetField, $fieldValue)) {
			$logs[] = "<a href=\"?\">[X]</a>";
		}
	}

	//loop on the search response hit ids and print them
	foreach($bxResponse->getHitFieldValues(array($facetField)) as $id => $fieldValueMap) {
		$logs[] = "<h3>$id</h3>";
		foreach($fieldValueMap as $fieldName => $fieldValues) {
			$logs[] = "$fieldName: " . implode(',', $fieldValues);
		}
	}

	if(!isset($print) || $print){
		echo implode("<br>", $logs);
	}
	
} catch(\Exception $e) {
	
	//be careful not to print the error message on your publish web-site as sensitive information like credentials might be indicated for debug purposes
	$exception = $e->getMessage();
	if(!isset($print) || $print) {
		var_dump($exception);
	}
}
