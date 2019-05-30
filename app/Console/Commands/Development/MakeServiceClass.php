<?php

namespace App\Console\Commands\Development;

use App\Console\Commands\Development\Helpers\ExtractsNamespaceConfig;
use App\Console\Commands\Development\Helpers\TransformsStubs;
use function class_basename;
use Closure;
use Illuminate\Console\Command;
use function is_dir;
use function str_replace;

class MakeServiceClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:make:service
        { path : The path to the service class to create from the src folder }
        { --S|search : Add the search method to the service }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new service class';

    /**
     * @var array
     */
    private $code = [
        'search' => [
            "use Deviate\Shared\Search\SearchContainerInterface;\n",
            "\n\n    public function search(SearchContainerInterface \$search): array\n    {\n        // return \$this->repository->search(\$this->normalizer->normalize(\$search));\n    }",
        ],
        'search_interface' => [
            "use Deviate\Shared\Search\SearchContainerInterface;\n\n",
            "public function search(SearchContainerInterface \$search): array;",
        ]
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config               = new ExtractsNamespaceConfig($this->argument('path'));
        $serviceStub          = new TransformsStubs(file_get_contents(__DIR__ . '/stubs/ServiceClassStub.txt'), $this->code);
        $serviceInterfaceStub = new TransformsStubs(file_get_contents(__DIR__ . '/stubs/ServiceClassInterfaceStub.txt'), $this->code);

        if (file_exists($config->getInstallPath())) {
            $this->output->error('File already exists');

            return;
        }

        $this->confirmConfig($config, $serviceStub, $serviceInterfaceStub,
            function ($config, $serviceStub, $serviceInterfaceStub) {
                $this->transformStub($config, $serviceStub);
                $this->transformStubInterface($config, $serviceInterfaceStub);

                $this->output->success('Service created!');
            });
    }

    private function confirmConfig(
        ExtractsNamespaceConfig $config,
        TransformsStubs $serviceStub,
        TransformsStubs $serviceInterfaceStub,
        Closure $callback
    ): void {
        $this->output->table(['Name', 'Value'], [
            ['Path', $config->getInstallPath()],
            ['Namespace', $config->getNamespace()],
            ['Interface', $config->getInterfaceNamespace() . '\\' . $config->getClassName() . 'Interface'],
            ['Classname', $config->getClassName()],
            ['Include Search', $this->option('search') ? 'Yes' : 'No'],
        ]);

        $confirmed = $this->output->confirm('Are you sure you want to create this service class?');

        if (!$confirmed) {
            $this->output->warning('Finishing without creating service.');

            return;
        }

        $callback($config, $serviceStub, $serviceInterfaceStub);
    }

    private function transformStub(ExtractsNamespaceConfig $config, TransformsStubs $stub)
    {
        $stub->remove('search', !$this->option('search'));
        $stub->replace('{{namespace}}', $config->getNamespace());
        $stub->replace('{{interface_namespace}}', $config->getInterfaceNamespace());
        $stub->replace('{{classname}}', $config->getClassName());

        $directory = str_replace(class_basename($config->getInstallPath()), '', $config->getInstallPath());

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        file_put_contents($config->getInstallPath(), $stub->getStub());
    }

    private function transformStubInterface(ExtractsNamespaceConfig $config, TransformsStubs $stub)
    {
        $stub->remove('search_interface', !$this->option('search'));
        $stub->replace('{{namespace}}', $config->getNamespace());
        $stub->replace('{{interface_namespace}}', $config->getInterfaceNamespace());
        $stub->replace('{{classname}}', $config->getClassName());

        $directory = str_replace(class_basename($config->getInterfaceInstallPath()), '', $config->getInterfaceInstallPath());

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        file_put_contents($config->getInterfaceInstallPath(), $stub->getStub());
    }
}
