<?php

namespace App\Console\Commands\Development\Helpers;

use function array_pop;

class ExtractsNamespaceConfig
{
    /** @var string */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getClassName()
    {
        $parts = explode('/', $this->path);

        return array_pop($parts);
    }

    public function getNamespace()
    {
        $parts = explode('/', $this->path);

        array_pop($parts);

        return 'Deviate\\' . implode('\\', $parts);
    }

    public function getInterfaceNamespace()
    {
        $parts = explode('/', $this->path);
        array_pop($parts);
        $service = array_shift($parts);

        array_unshift($parts, $service . '\\Contracts');

        return 'Deviate\\' . implode('\\', $parts);
    }

    public function getInstallPath()
    {
        return base_path('src/' . $this->path) . '.php';
    }

    public function getInterfaceInstallPath()
    {
        return base_path('src/' . str_replace('/Services', '/Contracts/Services', $this->path)) . 'Interface.php';
    }
}
