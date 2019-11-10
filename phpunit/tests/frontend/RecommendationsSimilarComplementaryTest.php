<?php
use PHPUnit\Framework\TestCase;

class RecommendationsSimilarComplementaryTest extends TestCase{

    private $account = "";
    private $password = "";
    private $apiKey = "";
    private $apiSecret = "";

    public function test_frontend_recommendations_similar_complementary(){
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

            $complementaryIds = range(11, 20);
            $similarIds = range(1, 10);
            include(__DIR__. "/../../../examples/frontend_recommendations_similar_complementary.php");
            $this->assertEquals($exception, null);
            $this->assertEquals($bxResponse->getHitIds($choiceIdSimilar), $similarIds);
            $this->assertEquals($bxResponse->getHitIds($choiceIdComplementary), $complementaryIds);
        }
    }
}