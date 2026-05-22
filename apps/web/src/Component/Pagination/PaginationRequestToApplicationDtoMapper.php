<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Pagination;

use InvalidArgumentException;
use Skeleton\Common\Application\Dto\PaginationDto;

final readonly class PaginationRequestToApplicationDtoMapper
{
    private const int MAX_PER_PAGE = 100;

    public function map(
        PaginationRequestDto $paginationRequest,
        int $maxPerPage = self::MAX_PER_PAGE,
    ): PaginationDto {
        $requestedPerPage = $paginationRequest->perPage;
        $limit = min($requestedPerPage, $maxPerPage);
        if ($limit <= 0) {
            throw new InvalidArgumentException('Pagination parameter "perPage" must be greater than zero.');
        }

        $page = $paginationRequest->page;
        if ($page <= 0) {
            throw new InvalidArgumentException('Pagination parameter "page" must be greater than zero.');
        }

        $offset = ($page - 1) * $limit;

        return new PaginationDto(
            limit: $limit,
            offset: $offset,
        );
    }
}
