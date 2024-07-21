<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunQueueWork extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:queue-work';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the queue:work command';

    /**
     * Execute the console command.
     */
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $this->call('queue:work');

    }
}
