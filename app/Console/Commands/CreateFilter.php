<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateFilter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'we make filter pipeline here';

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
        $filterName = $this->argument('name');
        $base = base_path('stubs/filter.stub');
        $to = base_path('app/Filters/' . $filterName . '.php');
        if(file_exists($to)){
            $this->error('file already exists. might wanna double check it, chief');
        }
        copy($base, $to);
        $this->replaceInFile('{{FilterName}}', $filterName, $to);
        $this->info('we good');
        return $filterName;
    }

    private function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
