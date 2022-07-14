<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;

class LoadDataPageScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapper:load_page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load default page web for scrapping';


    #[NoReturn] public function handle()
    {

    }

}
