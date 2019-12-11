<?php

//include the Boxalino Client SDK php files
require_once(__DIR__ . '/../vendor/autoload.php');
use com\boxalino\bxclient\v1\BxBatchClient;
use com\boxalino\bxclient\v1\BxBatchRequest;

$libPath = __DIR__ . '/../vendor/boxalino/boxalino-client-sdk-php/lib'; //path to the lib folder with the Boxalino Client SDK and PHP Thrift Client files
BxBatchClient::LOAD_CLASSES($libPath);

//required parameters you should set for this example to work
$account = "boxalino_automated_tests2"; // your account name
$logs = array(); //optional, just used here in example to collect logs
$isDev = false;

//Create the Boxalino Batch Client SDK instance
//N.B.: you should not create several instances of BxClient on the same page, make sure to save it in a static variable and to re-use it.
try {
    $language = "en"; // a valid language code (e.g.: "en", "fr", "de", "it", ...)
    $queryText = isset($queryText) ? $queryText : "dress"; // a search query
    $hitCount = 3; //a maximum number of search result to return in one page
    $fieldNames = ['products_title', 'discountedPrice', 'products_image', "id"];
    $choiceId = 'newsletter';
    $groupBy = "id";
    $customerIds =  [14589, 5268, 36547];


    //create batch request
    $bxClient = new BxBatchClient($account,"custom-api-key", "custom-api-secret", $isDev);
    $bxClient->addRequestContextParameter('dev_bx_disp', 'true');

    $bxRequest = new BxBatchRequest($language, $choiceId);
    $bxRequest->setMax($hitCount);
    $bxRequest->setGroupBy($groupBy);
    $bxRequest->setReturnFields($fieldNames);
    $bxRequest->setOffset(0);
    $bxRequest->setProfileIds($customerIds);

    //add the request
    $bxClient->setRequest($bxRequest);
    $bxResponse = $bxClient->getBatchChooseResponse();


    $response = [];
    $productDetails = $bxResponse->getHitFieldValuesForProfileIds();
    #response: {customer_id=> [{field1=>value, field2=>value,..}, {field1=>value, field2=>value, ..},..], customer_id=>[{}, {}, {}]}

    foreach($productDetails as $customerId => $productsCollection) {
        $clientRecommendation="customer $customerId:";

        foreach($productsCollection as $product)
        {
            foreach($product as $field=>$value)
            {
                $fieldValues = implode(",", $value);
                $clientRecommendation .= "$field - $fieldValues </br>";
            }

            $clientRecommendation .=";\n";
        }
        $response[] = $clientRecommendation;
    }

    echo implode("<br/>", $response);

    $response = [];
    $productIds = $bxResponse->getHitIds();
    #response = [customer_id=>[product1_id, product2_id, product3_id], ...]

    foreach($productIds as $customerId=>$productsList)
    {
        $clientRecommendation = "customer $customerId: " . implode(",", $productsList);
        $response[] = $clientRecommendation;
    }

    echo implode("<br/>", $response);

} catch(\Exception $e) {

    //be careful not to print the error message on your publish web-sixte as sensitive information like credentials might be indicated for debug purposes
    $exception = $e->getMessage();
    if(!isset($print) || $print) {
        echo $exception;
    }
}