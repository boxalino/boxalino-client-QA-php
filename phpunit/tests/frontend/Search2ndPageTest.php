<?php
use PHPUnit\Framework\TestCase;

class Search2ndPageTest extends TestCase{

    private $account = "";
    private $password = "";
    private $apiKey = "";
    private $apiSecret = "";

    public function test_frontend_search_2nd_page(){
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

            $hitIds = array(40, 41, 42, 44);
            include(__DIR__. "/../../../examples/frontend_search_2nd_page.php");
            $this->assertEquals($exception, null);
            $this->assertEquals($bxResponse->getHitIds(), $hitIds);
        }
    }
}