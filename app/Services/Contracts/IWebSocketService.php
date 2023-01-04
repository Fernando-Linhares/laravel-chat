<?php

namespace App\Services\Contracts;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

interface IWebSocketService extends MessageComponentInterface
{
    /**
     * Describe what do on send Message
     * @param ConnectionInterface $from
     * @param mixed $msg
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg);

    /**
     * Describe what do on close conection onClose
     * @param ConnectionInterface $conn
     * @return void
     */
    public function onClose(ConnectionInterface $conn);

    /**
     * Execute the message error of connection
     * @param ConnectionInterface $conn
     * @param \Exception $e
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e);
}