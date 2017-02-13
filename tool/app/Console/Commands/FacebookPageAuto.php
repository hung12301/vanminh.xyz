<?php 

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FacebookPageAuto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'facebook:auto';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto post content on pages';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        return app('App\Http\Controllers\Facebook_Controller')->AutoPost();
    }
}