<?php
use PHPUnit\Framework\TestCase;

class SearchFilterTest extends TestCase{

private $account = "";
    private $password = "";
    private $apiKey = "";
    private $apiSecret = "";

    public function test_frontend_search_filter(){
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

            include(__DIR__. "/../../../examples/frontend_search_filter.php");
            $this->assertEquals($exception, null);
            $this->assertTrue(!in_array("41", $bxResponse->getHitIds()));
            $this->assertTrue(!in_array("1940", $bxResponse->getHitIds()));
        }
    }
}