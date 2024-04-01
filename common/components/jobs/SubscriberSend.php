<?php
namespace common\components\jobs;

use yii\base\BaseObject;
use GuzzleHttp\Client;
use yii\log\Logger;
use yii\helpers\Console;

class SubscriberSend extends BaseObject implements \yii\queue\JobInterface
{
    public $message;

    public $phone;
    
    public function execute($queue)
    {
        $phone =  $this->phone; //'79081234567'; // номер телефона в международном формате
        $text = $this->message; // текст сообщения
        $sender = 'INFORM'; //  имя отправителя из списка https://smspilot.ru/my-sender.php
        // !!! Замените API-ключ на свой https://smspilot.ru/my-settings.php
        $apikey = 'XXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZXXXXXXXXXXXXYYYYYYYYYYYYZZZZZZZZ';
        
        $client = new Client();
        $response = $client->get('https://smspilot.ru/api.php', ['query' => [
                        'send' => urlencode($text),
                        'to' => urlencode($phone),
                        'from' => $sender,
                        'apikey' =>$apikey,
                        'format' => 'json',
                    ]
        ]);
            
        $content = $response->getBody()->getContents();
        $json = json_decode($content);
        
        Console::output("SubscriberSend: $content");
        
        if (!$json && isset($json->error)) {
            \Yii::getLogger()->log("error send to subscriber $content" , Logger::LEVEL_WARNING);
        }
    }
}