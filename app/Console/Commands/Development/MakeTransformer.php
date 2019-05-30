<?php

namespace App\Console\Commands\Development;

use App\Console\Commands\Development\Helpers\ExtractsNamespaceConfig;
use App\Console\Commands\Development\Helpers\TransformsStubs;
use Closure;
use Illuminate\Console\Command;

class MakeTransformer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:make:transformer
        {path : The path of the transformer to create from the src folder}
        {--C|collections : Can transform collections}
        {--S|search : Can transform search results}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new transformer for a service';

    /**
     * @var array
     */
    private $code = [
        'collections' => [
            "use Deviate\\Shared\\Transformers\\TransformsCollections;\n",
            ",\n        TransformsCollections",
        ],
        'search' => [
            "use Deviate\\Shared\\Transformers\\CanTransformSearchResults;\n",
            ",\n        CanTransformSearchResults",
        ],
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config = new ExtractsNamespaceConfig($this->argument('path'));
        $stub   = new TransformsStubs(file_get_contents(__DIR__ . '/stubs/TransformerStub.txt'), $this->code);

        if (file_exists($config->getInstallPath())) {
            $this->output->error('File already exists');

            return;
        }

        $this->confirmConfig($config, $stub, function ($config, $stub) {
            $this->transformStub($config, $stub);

            $this->output->success('Transformer created!');
        });
    }

    private function confirmConfig(ExtractsNamespaceConfig $config, TransformsStubs $stub, Closure $callback): void
    {
        $this->output->table(['Name', 'Value'], [
            ['Path', $config->getInstallPath()],
            ['Namespace', $config->getNamespace()],
            ['Classname', $config->getClassName()],
            ['Include Collections', $this->option('collections') ? 'Yes' : 'No'],
            ['Include Search', $this->option('search') ? 'Yes' : 'No'],
        ]);

        $confirmed = $this->output->confirm('Are you sure you want to create this transformer?');

        if (!$confirmed) {
            $this->output->warning('Finishing without creating transformer.');

            return;
        }

        $callback($config, $stub);
    }

    private function transformStub(ExtractsNamespaceConfig $config, TransformsStubs $stub)
    {
        $stub->remove('collections', $this->option('collections'));
        $stub->remove('search', $this->option('search'));
        $stub->replace('{{namespace}}', $config->getNamespace());
        $stub->replace('{{classname}}', $config->getClassName());

        file_put_contents($config->getInstallPath(), $stub->getStub());
    }
}
