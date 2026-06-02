<?php

declare(strict_types=1);

namespace Skeleton\Common;

use LogicException;
use RuntimeException;
use Skeleton\Common\Component\ModuleSystem\ModuleKernelTrait;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    use ModuleKernelTrait;

    public function __construct(
        string $environment,
        bool $debug,
        private readonly string $id,
    ) {
        parent::__construct($environment, $debug);
    }

    public function boot(): void
    {
        parent::boot();

        $timezone = $this->getContainer()->getParameter('timezone');
        if (!is_string($timezone) || $timezone === '') {
            throw new RuntimeException('Parameter timezone is not set.');
        }

        date_default_timezone_set($timezone);
    }

    public function getAppId(): string
    {
        return $this->id;
    }

    public function getCommonConfigDir(): string
    {
        return $this->getProjectDir() . '/config';
    }

    public function getAppConfigDir(): string
    {
        return $this->getProjectDir() . '/apps/' . $this->id . '/config';
    }

    public function getCacheDir(): string
    {
        $cacheDir = $_SERVER['APP_CACHE_DIR'] ?? $this->getProjectDir() . '/var/cache';

        return $cacheDir . '/' . $this->id . '/' . $this->environment;
    }

    public function getLogDir(): string
    {
        return ($_SERVER['APP_LOG_DIR'] ?? $this->getProjectDir() . '/var/log') . '/' . $this->id;
    }

    public function registerBundles(): iterable
    {
        foreach (array_merge($this->getCommonBundles(), $this->getAppBundles()) as $class => $envs) {
            if (!$this->isEnvironmentIncluded($envs)) {
                continue;
            }

            if (!class_exists($class)) {
                throw new RuntimeException(sprintf('Class %s does not exist.', $class));
            }

            /** @var BundleInterface $bundle */
            $bundle = new $class();
            yield $bundle;
        }
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $this->doConfigureContainer($container, $this->getCommonConfigDir());
        $this->doConfigureContainer($container, $this->getAppConfigDir());
    }

    protected function build(ContainerBuilder $container): void
    {
        $this->registerModules($container, $this->getModules());
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $this->doConfigureRoutes($routes, $this->getCommonConfigDir());
        $this->doConfigureRoutes($routes, $this->getAppConfigDir());
    }

    /**
     * @return array<class-string, array<string, bool>>
     */
    private function getCommonBundles(): array
    {
        return $this->readBundlesFile($this->getCommonConfigDir() . '/bundles.php');
    }

    /**
     * @return array<class-string, array<string, bool>>
     */
    private function getAppBundles(): array
    {
        return $this->readBundlesFile($this->getAppConfigDir() . '/bundles.php');
    }

    /**
     * @return array<class-string, array<string, bool>>
     */
    private function getModules(): array
    {
        $commonModules = $this->readModulesFile($this->getCommonConfigDir() . '/modules.php');
        $appModules = $this->readModulesFile($this->getAppConfigDir() . '/modules.php');

        $duplicatedModules = array_intersect_key($commonModules, $appModules);
        if ($duplicatedModules !== []) {
            throw new LogicException(sprintf(
                'There are duplicates in common and application modules: %s.',
                implode(', ', array_keys($duplicatedModules)),
            ));
        }

        return array_merge($commonModules, $appModules);
    }

    /**
     * @return array<class-string, array<string, bool>>
     */
    private function readModulesFile(string $filePath): array
    {
        return $this->readClassMapFile($filePath, 'Modules');
    }

    /**
     * @return array<class-string, array<string, bool>>
     */
    private function readBundlesFile(string $filePath): array
    {
        return $this->readClassMapFile($filePath, 'Bundles');
    }

    /**
     * @return array<class-string, array<string, bool>>
     */
    private function readClassMapFile(string $filePath, string $mapName): array
    {
        if (!is_file($filePath)) {
            throw new RuntimeException(sprintf('File %s does not exist.', $filePath));
        }

        $classMap = require $filePath;
        if (!is_array($classMap)) {
            throw new LogicException(sprintf('%s file %s must return array.', $mapName, $filePath));
        }

        return $classMap;
    }

    private function doConfigureContainer(ContainerConfigurator $container, string $configDir): void
    {
        $container->import($configDir . '/{packages}/*.{php,yaml}');
        $container->import($configDir . '/{packages}/' . $this->environment . '/*.{php,yaml}');

        if (is_file($configDir . '/services.yaml')) {
            $container->import($configDir . '/services.yaml');
        }

        if (is_file($configDir . '/services_' . $this->environment . '.yaml')) {
            $container->import($configDir . '/services_' . $this->environment . '.yaml');
        }
    }

    private function doConfigureRoutes(RoutingConfigurator $routes, string $configDir): void
    {
        $routes->import($configDir . '/{routes}/' . $this->environment . '/*.{php,yaml}');
        $routes->import($configDir . '/{routes}/*.{php,yaml}');

        if (is_file($configDir . '/routes.yaml')) {
            $routes->import($configDir . '/routes.yaml');
        }
    }

    /**
     * @param array<string, bool> $envs
     */
    private function isEnvironmentIncluded(array $envs): bool
    {
        return $envs[$this->environment] ?? $envs['all'] ?? false;
    }
}
