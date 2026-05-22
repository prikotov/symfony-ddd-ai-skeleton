<?php

declare(strict_types=1);

namespace Skeleton\Common\Exception;

use LogicException;

final class ConfigurationException extends LogicException implements ConfigurationExceptionInterface
{
}
