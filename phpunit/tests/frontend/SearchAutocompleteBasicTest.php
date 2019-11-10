<?php
use PHPUnit\Framework\TestCase;

class SearchAutocompleteBasicTest extends TestCase{

    private $account = "";
    private $password = "";
    private $apiKey = "";
    private $apiSecret = "";

    public function test_frontend_search_autocomplete_basic(){
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
            $textualSuggestions = array('ida workout parachute pant', 'jade yoga jacket', 'push it messenger bag');

            include(__DIR__. "/../../../examples/frontend_search_autocomplete_basic.php");
            $this->assertEquals($exception, null);
            $this->assertEquals($bxAutocompleteResponse->getTextualSuggestions(), $textualSuggestions);
        }
    }
}