<?php

namespace Wiltechsteam\FoundationServiceSingle\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Wiltechsteam\FoundationServiceSingle\LoggerHandler;

class FoundationServiceGetConfigCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'foundation:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Foundation Get Config';

    protected $loggerHandler;

    /**
     * FoundationServiceCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->loggerHandler = new LoggerHandler();
    }

    /**
     * Handle
     *
     */
    public function handle()
    {
        copy(
            __DIR__.'/stubs/config/foundation.stub',
            base_path('config/foundation.php')
        );

        $this->info('successfully.');
    }


}