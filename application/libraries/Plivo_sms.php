<?php

/**
 * Description of Plivo_sms
 *
 * @author dhareen
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Plivo_sms {

    public function __construct() {
        $CI = & get_instance();
    }

    /**
     * @uses TEST SMS
     * @return boolean
     */
    public function demoSMS() {
        # Plivo AUTH ID
        $AUTH_ID = 'MANZC3NWEZNZKXOGVHMZ';
        # Plivo AUTH TOKEN
        $AUTH_TOKEN = 'MTFkNmQ3MGUzOGUyMjQwNmM1ZDk0ODk0M2I2ZDBl';
        # SMS sender ID.
        $src = 'sms1234';
        # SMS destination number
        // Single NUMBER
        //  $dst = '917405173235';
        //MuitpleNumber
        //$dst = '917405173235<919662645054';
        # SMS text
        $text = 'Dev Gravity BPX';
        $url = PLIVO_API . $AUTH_ID . '/Message/';
        $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    /**
     *
     * @param Number $dstNumber-> Number on which you sms need to send
     * @param text $test -> SMS test
     * @return Boolan
     */
    public function send_sms($srcNumber,$dstNumber, $smstext) {
        if ($dstNumber == '' && $test == '') {
            exit('NUMBER OR TEXT NULL || ERROR');
        }
        # Plivo AUTH ID
        $AUTH_ID = 'MAZTC1M2VHNJGYOTBHZJ';
        # Plivo AUTH TOKEN
        $AUTH_TOKEN = 'OTk5ZjMyZDMzMjY5OGY1M2UzNmM4YWRmZjFlNGVm';
        # SMS sender ID.
        $src = $srcNumber;
        # SMS destination number
        $dst = $dstNumber;
        # SMS text
        $text = $smstext;
        $url = PLIVO_API . $AUTH_ID . '/Message/';
        $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function sendDummysms($number) {
        # Plivo AUTH ID
        $AUTH_ID = 'MAZTC1M2VHNJGYOTBHZJ';
        # Plivo AUTH TOKEN
        $AUTH_TOKEN = 'OTk5ZjMyZDMzMjY5OGY1M2UzNmM4YWRmZjFlNGVm';
        # SMS sender ID.
        $src = '19162459143';
        # SMS destination number
        // Single NUMBER
        $dst = $number;
        //MuitpleNumber
        //$dst = '917405173235<919662645054';
        # SMS text
        $text = 'Send Dummy SMS METHOD Gravity BPX';
        $url = PLIVO_API . $AUTH_ID . '/Message/';
        $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
        $data_string = json_encode($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    /**
     * @uses Receive An SMS
     */
    public function receiveSMS() {
        // Sender's phone numer
        $from_number = $_REQUEST["From"];
        // Receiver's phone number - Plivo number
        $to_number = $_REQUEST["To"];
        // The SMS text message which was received
        $text = $_REQUEST["Text"];
        // Output the text which was received to the log file.
//        $res = "Message received - From: $from_number, To: $to_number, Text: $text";
        return $_REQUEST;
    }

}
