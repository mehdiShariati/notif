<?php

namespace App\Notification;

use Exception;

class Telegram
{
    private static $instance;
    const MainBot = 'https://api.telegram.org/bot1145373187:AAHpKTKjK-T-ByIIvUACXdgFHVhpz8e_gio/';



    public $userData = array(
        // '+989122931505' => 59172133, // mofazl
        // '+989022931505' => 59172133, // mofazl
        // '+989392131590' => 32924192, // afsh
        // '+989122009848' => 877748834,// mahsa rafeezadeh
        // '+989128209484' => 95188288, // NASIM Behesht
        // '+989125500779' => 84020761, // Shadroo
        '+989123219662'=>"215329435"

    );


    private function _constructor()
    {
    }

    public static function instantiateTelegram()
    {
        if (self::$instance == null) {
            return self::$instance = new Telegram();
        }
        return self::$instance;
    }


    public function send($message)
    {

        $this->API_URL = self::MainBot;

        $phones = $this->userData;


        $result = [];

        foreach ($phones as $phone) {
            $phones = urldecode($phone);
            $message = urldecode($message);
            $chatId = $phone;

            if (!$chatId) {
                continue;
            }

            $res = $this->apiRequest('sendMessage', array('chat_id' => $chatId, 'text' => $message));
            $result[] = $res['message_id'];
        }


    }

    protected function getUpdates()
    {
        $leo = new Bot();
        $messages = $leo->apiRequestJson('getupdates', array());
        if (count($messages)) {
            foreach ($messages as $key => $value) {
                if (!$this->userList[$value['message']['chat']['id']]) {
                    $chatId = $value['message']['chat']['id'];
                    $username = $value['message']['chat']['username'];
                    $this->userList[$value['message']['chat']['id']] = $username;
                    echo 'chatId: ' . $chatId . ' - Username: ' . $username . '<br/>';
                }

            }
        }
    }

    protected function exec_curl_request($handle)
    {
        $response = curl_exec($handle);
        if ($response === false) {
            $errno = curl_errno($handle);
            $error = curl_error($handle);
            curl_close($handle);
            throw new Exception("Curl returned error $errno: $error\n");
//            echo("Curl returned error $errno: $error\n");
            return false;
        }
        $http_code = (int)curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        if ($http_code >= 500) {
            // do not wat to DDOS server if something goes wrong
            sleep(10);
            return false;
        }

        if ($http_code != 200) {
            $response = json_decode($response, true);
            error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
            if ($http_code == 401) {
                throw new Exception('Invalid access token provided');
            }
            return false;
        }


        $response = json_decode($response, true);
        if (isset($response['description'])) {
            error_log("Request was successfull: {$response['description']}\n");
        }
        $response = $response['result'];

        return $response;
    }

    protected function apiRequest($method, $parameters)
    {
        if (!is_string($method)) {
            error_log("Method name must be a string\n");
            return false;
        }

        if (!$parameters) {
            $parameters = array();
        } else if (!is_array($parameters)) {
            error_log("Parameters must be an array\n");
            return false;
        }

        foreach ($parameters as $key => &$val) {
            // encoding to JSON array parameters, for example reply_markup
            if (!is_numeric($val) && !is_string($val)) {
                $val = json_encode($val);
            }
        }
        $url = $this->API_URL . $method . '?' . http_build_query($parameters);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);


        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);

        try {
            return $this->exec_curl_request($handle);
        } catch (Exception $e) {
            $this->logger->addCritical('telegram send error: ' . $e->getMessage());
            return ['message_id' => -1];
        }
    }


}