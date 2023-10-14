<?php

namespace App\Console\Commands;

use App\Traits\MakeCommand;
use Illuminate\Console\Command;
class GenerateEnum extends Command
{
    use MakeCommand;

    protected const STUB_FILE_PATH = __DIR__ . "/Stubs/enum.stub";

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

    /**
     * Execute the console command.
     */
    public function handle():void
    {
        $this->prepareMakeCommand(app_path("Enums"), "App\\Enums")
            ->generateFromStub();
    }

    /**
     * @return array
     */
    protected function getStubVariables(): array
    {
        return [
            "ENUM_NAME" => $this->getClassName(),
            "NAMESPACE" => $this->getNamespace()
        ];
    }

    private function generateFromStub(): void
    {
        if (!$this->filesystem->exists($this->getFilename())) {
            $this->filesystem->put($this->getFilename(), $this->getFileContent(self::STUB_FILE_PATH));
            $this->info("Create " . $this->getClassName() . " sucessfully");
        } else {
            $this->error($this->className . " already exists");
        }
    }


}
