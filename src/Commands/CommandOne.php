<?php

namespace JoshuaBedford\LaravelWordFilter\Commands;

use Illuminate\Console\Command;

class CommandOne extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wordlist:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the wordlist package.';

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
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle(DripEmailer $drip)
    {
        echo "installing"
    }
}