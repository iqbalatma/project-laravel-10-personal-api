<?php

namespace App\Traits;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

trait MakeCommand
{
    protected string $argumentName;
    protected string $className;
    protected string $targetPath;
    protected string $filename;
    protected string $namespace;
    protected Filesystem $filesystem;

    /**
     * @return Command
     */
    public function getConsoleInstance(): Command
    {
        return $this;
    }

    /**
     * @return Command|MakeCommand
     */
    protected function setArgumentName(): self
    {
        $this->argumentName = $this->getConsoleInstance()->argument("name");
        return $this;
    }

    /**
     * @return string
     */
    protected function getArgumentName(): string
    {
        return $this->argumentName;
    }

    /**
     * @return Command|MakeCommand
     */
    protected function setClassName(): self
    {
        $this->className = ucwords(last(explode("/", $this->getArgumentName())));
        return $this;
    }

    /**
     * @return string
     */
    protected function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param string $targetPath
     * @return Command|MakeCommand
     */
    protected function setTargetPath(string $targetPath): self
    {
        $this->targetPath = $targetPath;

        /**
         * example: if argument only Role
         * it's meant no need to nest path
         * but if argument is nested, we will create new directory with nest path
         */
        if (($dirname = dirname($this->getArgumentName())) !== ".") {
            $this->targetPath .= "/$dirname";
        }
        return $this;
    }

    /**
     * @return string
     */
    protected function getTargetPath(): string
    {
        return $this->targetPath;
    }

    /**
     * @return Command|MakeCommand
     */
    protected function setFilename(): self
    {
        $this->filename = $this->getTargetPath() . "/" . $this->getClassName() . ".php";
        return $this;
    }

    /**
     * @return string
     */
    protected function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $defaultNamespace
     * @return Command|MakeCommand
     */
    private function setNamespace(string $defaultNamespace): self
    {
        $this->namespace = $defaultNamespace;
        if (($dirname = dirname($this->getArgumentName())) !== "."){
            $dirname = str_replace("/", "\\", $dirname);
            $this->namespace .="\\$dirname";
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getNamespace():string
    {
        return $this->namespace;
    }

    /**
     * @return Command|MakeCommand
     */
    protected function makeDirectory(): self
    {
        $this->filesystem = new Filesystem();

        if (!$this->filesystem->isDirectory($this->getTargetPath())) {
            $this->filesystem->makeDirectory($this->getTargetPath());
        }
        return $this;
    }

    protected abstract function getStubVariables():array;

    protected function getFileContent(string $stubPath): string
    {
        $stubContent = file_get_contents($stubPath);

        foreach ($this->getStubVariables() as $key => $variable) {
            $stubContent = str_replace("*$key*", $variable, $stubContent);
        }
        return $stubContent;
    }

    protected function prepareMakeCommand(string $targetPath, string $defaultNamespace):self
    {
        $this->setArgumentName()
            ->setClassName()
            ->setTargetPath($targetPath)
            ->setFilename()
            ->setNamespace($defaultNamespace)
            ->makeDirectory();

        return $this;
    }

}
