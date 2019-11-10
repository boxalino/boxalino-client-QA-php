<?php
use PHPUnit\Framework\TestCase;

class SearchFacetTest extends TestCase{

    private $account = "";
    private $password = "";
    private $apiKey = "";
    private $apiSecret = "";

    public function test_frontend_search_facet(){
        global $argv;
        $hosts = ['main.bx-cloud.com', 'track.bx-cloud.com'];
        $bxHosts = (isset($argv[4]) ? ($argv[4] == 'all' ? $hosts : array($argv[4])) : $hosts);
        $timeout = isset($argv[5]) ? $argv[5] : 2000;
        foreach ($bxHosts as $bxHost) {
            $account = $this->account;
            $password = $this->password;
            $apiKey = $this->apiKey;
            $apiSecret = $this->apiSecret;
            $host = $bxHost;
            $print = false;
            $exception = null;

            //testing the result of the frontend search facet case
            include(__DIR__. "/../../../examples/frontend_search_facet.php");
            $this->assertEquals($exception, null);
            $this->assertEquals($bxResponse->getHitFieldValues(array($facetField))[41], array('products_color' => array('Black', 'Gray', 'Yellow')));
            $this->assertEquals($bxResponse->getHitFieldValues(array($facetField))[1940], array('products_color' => array('Gray', 'Orange', 'Yellow')));
        }
    }
}