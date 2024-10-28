<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utils\EnviarPush;


class MessageController extends Controller
{
    public function sendPusher(Request $request)
    {
        $title = $request->title;
        $message = $request->message;

        // validate request
        $request->validate([
            'title' => 'required',
            'message' => 'required',
        ]);

        $error = EnviarPush::enviarMensaje($title, $message);

        if ($error) {
            return response()->json(['message' => 'Error sending Pusher event. ' . $error->getMessage()], 500);
        }

        return response()->json(['message' => 'Pusher event sent', 200]);
    }
}
