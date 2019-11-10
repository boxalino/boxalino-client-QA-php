<?php
use PHPUnit\Framework\TestCase;

class SearchBasicTest extends TestCase
{
    private $account = "";
    private $password = "";
    private $apiKey = "";
    private $apiSecret = "";

	public function test_frontend_search_basic(){
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
			$hitIds = array(41, 1940, 1065, 1151, 1241, 1321, 1385, 1401, 1609, 1801);

			//testing the result of the frontend search basic case
			$queryText = "women";
			include(__DIR__. "/../../../examples/frontend_search_basic.php");
			$this->assertEquals($exception, null);
			$this->assertEquals($bxResponse->getHitIds(), $hitIds);
			
			//testing the result of the frontend search basic case with semantic filtering blue => products_color=Blue
			$queryText = "blue";
			include(__DIR__. "/../../../examples/frontend_search_basic.php");
			$this->assertEquals($exception, null);
			$this->assertEquals($bxResponse->getTotalHitCount(), 79.0);
			
			//testing the result of the frontend search basic case with semantic filtering forcing zero results pink => products_color=Pink
			$queryText = "pink";
			include(__DIR__. "/../../../examples/frontend_search_basic.php");
			$this->assertEquals($exception, null);
			$this->assertEquals($bxResponse->getTotalHitCount(), 8.0);

			//testing the result of the frontend search basic case with semantic filtering setting a filter on a specific product only if the search shows zero results (this one should not do it because workout shows results)
			$queryText = "workout";
			include(__DIR__. "/../../../examples/frontend_search_basic.php");
			$this->assertEquals($exception, null);
			$this->assertEquals($bxResponse->getTotalHitCount(), 28);

			//testing the result of the frontend search basic case with semantic filtering setting a filter on a specific product only if the search shows zero results (this one should do it because workoutoup shows no results)
			$queryText = "workoutoup";
			include(__DIR__. "/../../../examples/frontend_search_basic.php");
			$this->assertEquals($exception, null);
			$this->assertEquals($bxResponse->getTotalHitCount(), 0.0);
		}
	}
}
