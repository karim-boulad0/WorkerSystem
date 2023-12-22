<?php

namespace App\Console\Commands;

use App\Console\Commands\FileFactoryCommand;

class CreateInterface extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {className}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    function setStubName(): string
    {
        return 'interfacePattern';
    }
    function setFilePath(): string
    {
        return 'App\\Interfaces\\';
    }
    function setSuffix(): string
    {
        return 'Interfaces';
    }
    function setInfo(): string
    {
        return 'Interface class created successfully: ';
    }

}
