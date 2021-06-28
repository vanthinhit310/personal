<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Example extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:example';

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
     * @return void
     */
    public function handle()
    {
        $output = [];
//        $command = escapeshellcmd('py D:/python/projects/tesseract/main.py');
//        $output = shell_exec($command);
        exec('py D:/python/projects/tesseract/main.py', $output);
//        $this->info(str_replace("b'|","'|", $output[0]));
//        $str = str_replace(["b'|", "'"], ["", ""], $output[0]);
//        dump($str,$output[0]);
        dd(utf8_decode($output[0]));
//        dd(utf8_decode("'|\n\nLorem ipsum dolor sit amet...\n\nHow to use css to truncate text strings with ellipsis\n\x0c'"));
    }

}
