<?php

declare(strict_types=1);

namespace Skeleton\Console\Module\Diagnostics\Command\Runtime;

use JsonException;
use LogicException;
use Override;
use Skeleton\Common\Application\Component\QueryBus\QueryBusComponentInterface;
use Skeleton\Common\Module\Diagnostics\Application\Dto\RuntimeDiagnosticsDto;
use Skeleton\Common\Module\Diagnostics\Application\UseCase\Query\GetRuntimeDiagnostics\GetRuntimeDiagnosticsQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:diagnostics:runtime',
    description: 'Shows read-only runtime diagnostics for the selected application.',
)]
final class CheckCommand extends Command
{
    public function __construct(
        private readonly QueryBusComponentInterface $queryBus,
    ) {
        parent::__construct();
    }

    /**
     * @throws JsonException
     */
    #[Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $diagnostics = $this->queryBus->query(new GetRuntimeDiagnosticsQuery('console-command'));
        if (!$diagnostics instanceof RuntimeDiagnosticsDto) {
            throw new LogicException(sprintf('Expected %s diagnostics result.', RuntimeDiagnosticsDto::class));
        }

        $output->writeln(json_encode(
            $this->normalize($diagnostics),
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES,
        ));

        return Command::SUCCESS;
    }

    /**
     * @return array{status: string, entrypoint: string, app: string, environment: string, debug: bool, timezone: string, checkedAt: string}
     */
    private function normalize(RuntimeDiagnosticsDto $diagnostics): array
    {
        return [
            'status' => $diagnostics->status,
            'entrypoint' => $diagnostics->entrypoint,
            'app' => $diagnostics->appId,
            'environment' => $diagnostics->environment,
            'debug' => $diagnostics->debug,
            'timezone' => $diagnostics->timezone,
            'checkedAt' => $diagnostics->checkedAt->format(DATE_ATOM),
        ];
    }
}
