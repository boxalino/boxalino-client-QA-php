<?php
use PHPUnit\Framework\TestCase;

class SearchCorrectedTest extends TestCase{

    private $account = "boxalino_automated_tests2";
    private $password = "boxalino_automated_tests2";

    public function test_frontend_search_corrected(){
        global $argv;
        $hosts = ['cdn.bx-cloud.com', 'api.bx-cloud.com'];
        $bxHosts = (isset($argv[4]) ? ($argv[4] == 'all' ? $hosts : array($argv[4])) : $hosts);
        $timeout = isset($argv[5]) ? $argv[5] : 2000;
        foreach ($bxHosts as $bxHost) {
            $account = $this->account;
            $password = $this->password;
            $host = $bxHost;
            $print = false;
            $exception = null;
            $hitIds = array(41, 1940, 1065, 1151, 1241, 1321, 1385, 1401, 1609, 1801);

            include(__DIR__. "/../../../examples/frontend_search_corrected.php");
            $this->assertEquals($exception, null);
            $this->assertEquals($bxResponse->areResultsCorrected(), true);
            $this->assertEquals($bxResponse->getHitIds(), $hitIds);
        }
    }
}