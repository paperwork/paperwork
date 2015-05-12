<?php

namespace Paperwork\App\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PaperworkUpdate extends AbstractPaperworkCommand
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'paperwork:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates paperwork from github and rebuilds stuff';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if (self::checkRequiredCommands()) {
            $scripts = [
                'git pull',
                'composer update',
                'npm update',
                'npm run bower-update',
                'npm run build',
            ];

            self::batchRun($scripts);

            echo 'Done.' . PHP_EOL;
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

}
