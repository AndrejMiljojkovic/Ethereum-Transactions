<?php
class Data
{
    const API_KEY = '3JK333Q4Q4AVKSFE41JXUD1MI9ZZMQZSFC';
    private $walletAddress;
    private $startBlock;
    private $dueDate;

    public function __construct($walletAddress, $startBlock, $dueDate = false)
    {
        $this->walletAddress = $walletAddress;
        $this->startBlock = $startBlock;
        $this->dueDate = $dueDate;
    }
    private function convertTimeToBlock()
    {
        $apiURL = 'https://api.etherscan.io/api?module=block&action=getblocknobytime&timestamp=' . $this->dueDate . '&closest=before&apikey=' . self::API_KEY;
        return $this->apiCall($apiURL);
    }
    public function apiCall($apiURL)
    {
        $toBeReturned = false;
        $header = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . self::API_KEY, // Your API key
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        if ($response === false) {
            echo 'cURL error: ' . curl_error($ch);
        } else {
            $data = json_decode($response, true);
            if (!isset($data["status"]) || $data["status"] == "1") {
                $toBeReturned = $data['result'];
            } else {
                echo 'Error: Unable to retrieve transaction data';
            }
        }
        return $toBeReturned;
    }

    public function allTheData()
    {
        $theData = [];
        $currentBalance = 0;
        $apiURL = "https://api.etherscan.io/api?module=account&action=txlist&address=$this->walletAddress&startblock=$this->startBlock&endblock=";
        if ($this->dueDate != false) {
            $theData['dueDate'] = $this->dueDate;
            $blockNo = $this->convertTimeToBlock();
            $apiURL .= $blockNo;
        } else {
            $apiURL .= "latest";
        }
        $apiURL .= "&sort=asc&apikey=" . self::API_KEY . "&internal=true";
        $theData['API'] = $apiURL;
        $transactions = $this->apiCall($apiURL);
        if (!empty($transactions)) {
            foreach ($transactions as $transaction) {
                if ($transaction['value'] != 0) {
                    $transaction['value'] = $transaction['value'] / 1e18;
                    if ($transaction["from"] == $this->walletAddress) {
                        $currentBalance -= $transaction['value'];
                    } elseif ($transaction["to"] == $this->walletAddress) {
                        $currentBalance += $transaction['value'];
                    }
                }
                $theData['currentBalance'] = $currentBalance;
                $transaction['timeFormatted'] = date('Y-m-d H:i:s', $transaction['timeStamp']);
                $theData['transactions'][] = $transaction;
            }
            header('Content-Type: application/json');
            echo json_encode($theData);
        } else {
            echo '<p>No transactions found for the given address and block range.</p>';
        }
    }
}
$walletAddress = $_GET['walletAddress'];
$startBlock = $_GET['startBlock'];
$dueDate = $_GET['dueDate'];
$data = new Data($walletAddress, $startBlock, $dueDate);
$data->allTheData();
