<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem\DependencyInjection;

use Exception;
use Override;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final readonly class ModuleCompilerPass implements CompilerPassInterface
{
    public function __construct(
        private string $serviceConfigPath,
        private string $environment,
    ) {
    }

    /**
     * @throws Exception
     */
    #[Override]
    public function process(ContainerBuilder $container): void
    {
        $yamlLoader = new YamlFileLoader($container, new FileLocator($this->serviceConfigPath), $this->environment);
        $yamlLoader->load('services.yaml');

        $phpLoader = new PhpFileLoader($container, new FileLocator($this->serviceConfigPath), $this->environment);
        if (is_file($this->serviceConfigPath . '/services.php')) {
            $phpLoader->load('services.php');
        }

        $environmentServices = sprintf('services_%s.php', $this->environment);
        if (is_file($this->serviceConfigPath . '/' . $environmentServices)) {
            $phpLoader->load($environmentServices);
        }
    }
}
