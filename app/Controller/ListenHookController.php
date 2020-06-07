<?php
namespace App\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Notification\Telegram;
class ListenHookController extends _Controller
{
    public function index(Request $request, Response $response, array $args = []):Response
    {
        $data=json_decode(file_get_contents("php://input"),true);
        $notif=[
            "type"=>$data["event_type"],
            "summary"=>$data['summary']
        ];
        Telegram::instantiateTelegram()->send($notif);
        return $response;
    }
}

