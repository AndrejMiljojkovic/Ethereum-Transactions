<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/back.php');
class Balance extends Data
{
    private $balanceDate;
    public $walletAddress;
    public function __construct($balanceDate, $walletAddress)
    {
        $this->walletAddress = $walletAddress;
        $this->balanceDate = $balanceDate;
    }

    private function convertTimeToBlock()
    {
        $apiURL = 'https://api.etherscan.io/api?module=block&action=getblocknobytime&timestamp=' . $this->balanceDate . '&closest=before&apikey=' . self::API_KEY;
        echo $apiURL . '<br>';
        echo 'napravio api za convertTimeToBlock()' . '<br>';
        $result = $this->apiCall($apiURL);
        echo 'uradio apicall 1' . '<br>';
        return $result;
    }

    public function calculateBalance()
    {
        $blockNo = $this->convertTimeToBlock();
        echo 'dobio blockno';
        echo $blockNo . '<br>';
        $apiURL = 'https://api.etherscan.io/api?module=account&action=balancehistory&address=' . $this->walletAddress . '&blockno=' . $blockNo . '&apikey=' . self::API_KEY;
        echo $apiURL . '<br>';
        echo 'napravio api za calculateBalance()' . '<br>';
        $calculatedBalance = $this->apiCall($apiURL);
        echo 'uradio apicall 2' . '<br>';
        //$calculatedBalance = $calculatedBalance / 1e18;
        echo $calculatedBalance . '<br>';
        return $calculatedBalance;
    }
}
$balanceDate = $_GET['balanceDate'];
$walletAddress = $_GET['walletAddress'];
$balanceData = new Balance($balanceDate, $walletAddress);
$balanceData->calculateBalance();
