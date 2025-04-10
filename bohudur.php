<?php
!defined('BOHUDUR') && exit("what's you are trying to do?");

class Bohudur {
    private static $requestUrl = "https://request.bohudur.one/create/";
    private static $verifyUrl = "https://request.bohudur.one/verify/";
    private static $executeUrl = "https://request.bohudur.one/execute/";
    
    private $apiKey;
    
    public function __construct($apiKey) {
        if(ctype_alnum($apiKey)) {
            $this->apiKey = $apiKey;
        } else {
            $this->returnResponse(2001, "Invalid API key");
        }
    }
    
    public function sendRequest($requestData) {
        if(!$this->validateRequestData($requestData)) {
            $this->returnResponse(2002, "Required Parameters Not Found!");
        }
        
        $headers = [
            'Content-Type: application/json',
            'AH-BOHUDUR-API-KEY: ' . $this->apiKey
        ];
        
        $data = json_encode($requestData);
        
        $ch = curl_init(self::$requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $this->returnResponse(2003, curl_error($ch));
        }
        
        curl_close($ch);
        return $response;
    }
    
    public function executePayment($paymentKey) {
        $requestData = json_encode([
            'paymentkey' => $paymentKey
        ]);
        
        $headers = [
            'Content-Type: application/json',
            'AH-BOHUDUR-API-KEY: ' . $this->apiKey
        ];
        
        $ch = curl_init(self::$executeUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $this->returnResponse(2004, curl_error($ch));
        }
        
        curl_close($ch);
        return $response;
    }
    
    public function verifyPayment($paymentKey) {
        $requestData = json_encode([
            'paymentkey' => $paymentKey
        ]);
        
        $headers = [
            'Content-Type: application/json',
            'AH-BOHUDUR-API-KEY: ' . $this->apiKey
        ];
        
        $ch = curl_init(self::$verifyUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            $this->returnResponse(2004, curl_error($ch));
        }
        
        curl_close($ch);
        return $response;
    }
    
    private function validateRequestData($requestData) {
        if (!isset($requestData['fullname'], $requestData['amount'], $requestData['redirect_url'], $requestData['cancelled_url'], $requestData['return_type'], $requestData['email'])) {
            return false;
        }
        
        return true;
    }
    
    private function returnResponse($code, $message) {
        echo json_encode(['responseCode' => $code, 'message' => $message, 'status' => "failed"]);
    }
}
