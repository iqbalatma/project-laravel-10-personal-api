<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class GenerateEnum extends Command
{
    private const STUB_FILE_PATH = __DIR__ . "/Stubs/enum.stub";
    private string $targetPath;
    private string $filename;
    private string $enumName;
    private string $namespace;


    protected Filesystem $filesystem;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name : enum name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new enum';


    private function setEnumName(): self
    {
        $name = $this->argument("name");
        $explodedName = explode("/", $name);

        $this->enumName = ucwords(end($explodedName));
        return $this;
    }

    private function setTargetPath(): self
    {
        $this->targetPath = app_path("Enums");
        if (($dirname = dirname($this->argument("name"))) !== "."){
            $this->targetPath .="/$dirname";
        }
        return $this;
    }

    private function setFilename(): self
    {
        $this->filename = $this->getTargetPath() . "/" . $this->getEnumName() . ".php";
        return $this;
    }

    private function setNamespace(): self
    {
        $this->namespace = "App\\Enums";
        if (($dirname = dirname($this->argument("name"))) !== "."){
            $dirname = str_replace("/", "\\", $dirname);
            $this->namespace .="\\$dirname";
        }

        return $this;
    }


    private function getTargetPath(): string
    {
        return $this->targetPath;
    }

    private function getEnumName(): string
    {
        return $this->enumName;
    }

    private function getNamespace(): string
    {
        return $this->namespace;
    }

    private function getFilename(): string
    {
        return $this->filename;
    }

    protected function makeDirectory(): self
    {
        $this->filesystem = new Filesystem();

        if (!$this->filesystem->isDirectory($this->getTargetPath())) {
            $this->filesystem->makeDirectory($this->getTargetPath());
        }
        return $this;
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->setEnumName()
            ->setTargetPath()
            ->setFilename()
            ->setNamespace()
            ->makeDirectory()
            ->generateFromStub();

    }

    public function getStubVariables(): array
    {
        return [
            "ENUM_NAME" => $this->getEnumName(),
            "NAMESPACE" => $this->getNamespace()
        ];
    }

    private function getFileContent(): string
    {
        $stubContent = file_get_contents(self::STUB_FILE_PATH);

        foreach ($this->getStubVariables() as $key => $variable) {
            $stubContent = str_replace("*$key*", $variable, $stubContent);
        }
        return $stubContent;
    }


    private function generateFromStub(): void
    {
        if (!$this->filesystem->exists($this->getFilename())) {
            $this->filesystem->put($this->getFilename(), $this->getFileContent());
            $this->info("Create enum " . $this->getEnumName() . " sucessfully");
        } else {
            $this->error("Enum already exists");
        }
    }


}
