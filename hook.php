<?php

require_once 'bot-api-config.php';
require_once 'bot-api-fungsi.php';
require_once 'bot-api-proses.php';

$entityBody = file_get_contents('php://input');
$message = json_decode($entityBody, true);
prosesApiMessage($message);

defined('BASEPATH') OR exit('No direct script access allowed');

class Bot extends CI_Controller {
    function __construct(){
        parent::__construct();
    }

    function index(){
        $TOKEN = "2121377550:AAHXoQ86L-nNSXCDBXh33IgwfUva4U9QUus";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        
        if (strpos($message, "/start") === 0) {
        
        file_get_contents($apiURL."/sendmessage?chat_id=".$chatID."&text=Haloo, test webhooks dicoffeean.com.&parse_mode=HTML"); 
        } 
    } 
}
