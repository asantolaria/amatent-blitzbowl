<?php

namespace App\Utils;

use Pusher\Pusher;

class EnviarPush
{
    public static function enviarMensaje($title, $message)
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY'), env('PUSHER_APP_SECRET'), env('PUSHER_APP_ID'), array('cluster' => env('PUSHER_APP_CLUSTER')));

        $data = ['message' => $message, 'title' => $title];

        try {
            $channels = $pusher->trigger(
                'my-channel',
                'my-event',
                $data,
                array('info' => 'subscription_count'),
            );
            return NULL;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
