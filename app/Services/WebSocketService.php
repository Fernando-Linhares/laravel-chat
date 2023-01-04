<?php

namespace App\Services;

use Ratchet\ConnectionInterface;
use App\Services\Contracts\IWebSocketService;
use App\Models\Message;

class WebSocketService implements IWebSocketService
{
    /**
     * @param \SplObjectStorage $client
     */
    public function __construct(
        protected \SplObjectStorage $clients
    ){}

    /**
     * Describe what do on send Message
     * @param ConnectionInterface $from
     * @param mixed $msg
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $request = json_decode($msg);

        Message::create([
            'user_id' => $request->id,
            'text' => $request->text,
            'time' => $request->time,
        ]);

        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    /**
     * Describe what do on close conection onClose
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

     /**
     * Describe what do on close conection onClose
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * Execute the message error of connection
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}