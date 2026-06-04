<?php

declare(strict_types=1);

namespace Skeleton\Common\Component\ModuleSystem\Extension;

/**
 * Extension interface for modules that own Doctrine entities.
 *
 * Modules implementing this interface declare their entity namespace
 * and mapping path. The kernel registers them as explicit ORM mapping
 * drivers — never via `auto_mapping: true`.
 */
interface DoctrineInterface
{
    /**
     * Root namespace of the module's Doctrine entities.
     *
     * Example: `__NAMESPACE__ . '\Domain\Entity'`
     */
    public function getEntityNamespace(): string;

    /**
     * Absolute path to the directory containing entity classes.
     *
     * Example: `$this->getModuleDir() . '/Domain/Entity'`
     */
    public function getMappingPath(): string;
}
