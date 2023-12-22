<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\FileFactoryCommand;

class CreateRepository extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {className}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    function setStubName(): string
    {
        return 'repository';
    }
    function setFilePath(): string
    {
        return 'App\\Repositories\\';
    }
    function setSuffix(): string
    {
        return 'Repositories';
    }
    function setInfo(): string
    {
        return 'Repository class created successfully: ';
    }
}
