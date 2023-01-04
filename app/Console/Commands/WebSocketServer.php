<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Contracts\IWebSocketService;

class WebSocketServer extends Command
{
    public function __construct(
        private IWebSocketService $service
    ){
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'server:up';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Starts webscocket server responsible to connect the clients to chat';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $port = 9090;
        
        $address = 'localhost';

        $this->info("Server listen on port: {$port}, address: {$address}");

        $app = new \Ratchet\App('localhost', $port);
        
        $app->route('/', $this->service, array('*'));
        
        $app->run();

        return Command::SUCCESS;
    }
}
