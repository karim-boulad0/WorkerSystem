<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Commands\FileFactoryCommand;

class CreateServiceClass extends FileFactoryCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {className}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this Command for create service class pattern ';

    function setStubName(): string
    {
        return 'servicePattern';
    }
    function setFilePath(): string
    {
        return 'App\\Services\\';
    }
    function setSuffix(): string
    {
        return 'Services';
    }

    function setInfo(): string
    {
        return 'Service class created successfully: ';
    }
}
