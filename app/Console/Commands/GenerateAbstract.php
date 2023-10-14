<?php

namespace App\Console\Commands;

use App\Traits\MakeCommand;
use Illuminate\Console\Command;

class GenerateAbstract extends Command
{
    use MakeCommand;

    protected const STUB_FILE_PATH = __DIR__ . "/Stubs/abstract.stub";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:abstract {name : abstract name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->prepareMakeCommand(app_path("Contracts/Abstracts"), "App\\Contracts\\Abstracts")
            ->generateFromStub(self::STUB_FILE_PATH);
    }

    protected function getStubVariables(): array
    {
        return [
            "CLASS_NAME" => $this->getClassName(),
            "NAMESPACE" => $this->getNamespace()
        ];
    }
}
