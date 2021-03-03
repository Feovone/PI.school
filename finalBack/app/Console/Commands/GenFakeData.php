<?php

namespace App\Console\Commands;

use App\Services\GeneratorFakeAction;
use Illuminate\Console\Command;

class GenFakeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:id {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $generator = new GeneratorFakeAction($this->argument('id'));
        $generator->generate();
        return 0;
    }
}
