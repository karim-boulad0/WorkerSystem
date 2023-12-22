<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\filesystem\FileSystem;
use Illuminate\Support\Pluralizer;

abstract class FileFactoryCommand extends Command
{
    /**
     * File system instance for handling file operations.
     *
     * @var FileSystem
     */
    protected $file;

    /**
     * Create a new command instance.
     *
     * @param  FileSystem  $file
     * @return void
     */
    public function __construct(FileSystem $file)
    {
        parent::__construct();
        $this->file = $file;
    }

    /**
     *Abstract
     *Abstract
     *Abstract
     *Abstract
     */
    abstract function setStubName(): string;
    abstract function setFilePath(): string;
    abstract function setSuffix(): string;
    abstract function setInfo(): string;

    /**
     * Convert a plural class name to a singular form.
     *
     * @param  string  $name
     * @return string
     */

    public function singleClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
    }

    /**
     * Create directories recursively if they don't exist.
     *
     * @param  string  $path
     * @return string
     */
    public function makeDir($path)
    {
        $this->file->makeDirectory($path, 0777, true, true);
        return $path;
    }

    /**
     * Get the path to the stub file.
     *
     * @return string
     */
    public function stubPath()
    {
        $stub = $this->setStubName();
        return __DIR__ . "/../../../stubs/{$stub}.stub";
    }

    /**
     * Prepare variables to be replaced in the stub content.
     *
     * @return array
     */
    public function stubVariables()
    {
        $name =  [
            'Name' => $this->argument('className') . $this->singleClassName($this->setSuffix()), // Use 'Name' instead of 'NAME'
        ];
        return $name;
    }

    /**
     * Read the content of the stub file and replace placeholders with actual values.
     *
     * @param  string  $stubPath
     * @param  array  $stubVariables
     * @return string
     */
    public function stubContent($stubPath, $stubVariables)
    {
        $content = file_get_contents($stubPath);
        foreach ($stubVariables as $search => $name) {
            $content = str_replace('$' . $search, $name, $content); // Change $Name to $NAME
        }
        return $content;
    }

    /**
     * Generate the full path where the service class file will be created.
     *
     * @return string
     */
    public function getPath()
    {
        $setSuffix = $this->singleClassName($this->setSuffix());
        $FilePath = $this->setFilePath();
        return base_path($FilePath) . $this->singleClassName($this->argument('className')) . "{$setSuffix}.php";
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $className = $this->argument('className');

        // Get the path where the service class file will be created
        $filePath = $this->getPath();

        // Check if the file already exists
        if ($this->file->exists($filePath)) {
            $this->error('Service class already exists!');
            return;
        }

        // Get the content of the stub file
        $stubPath = $this->stubPath();
        $stubVariables = $this->stubVariables();
        $contents = $this->stubContent($stubPath, $stubVariables);

        // Get the directory path
        $directoryPath = dirname($filePath);

        // Create the directory if it doesn't exist
        $this->makeDir($directoryPath);

        // Create the service class file
        $this->file->put($filePath, $contents);
        $setInfo =  $this->setInfo();
        $this->info($setInfo . $className);
    }
}
