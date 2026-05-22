<?php

declare(strict_types=1);

namespace Skeleton\Web\Component\Twig\Phoenix;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class Pagination
{
    public string $route;
    public int $page;
    public int $perPage;
    public int $total;
    public int $maxVisiblePages = 10;
    public ?string $sort = null;
    public array $filter = [];

    private ?int $totalPage = null;

    public function pages(): array
    {
        if ($this->maxVisiblePages >= $this->getTotalPage()) {
            $firstPage = 1;
            $lastPage = $this->getTotalPage();
        } else {
            $firstPage = max(1, (int)round((float)$this->page - ((float)$this->maxVisiblePages / 2.0)));
            $lastPage = min($this->getTotalPage(), $firstPage + $this->maxVisiblePages - 1);
        }

        $pages = [];
        for ($i = $firstPage; $i <= $lastPage; $i++) {
            $pages[] = $i;
        }

        return $pages;
    }

    public function getTotalPage(): int
    {
        if ($this->totalPage === null) {
            $this->totalPage = ($this->perPage > 0)
                ? (int)ceil($this->total / $this->perPage)
                : 0;
        }
        return $this->totalPage;
    }

    public function getFirstItem(): int
    {
        if ($this->total === 0) {
            return 0;
        }

        return ($this->page - 1) * $this->perPage + 1;
    }

    public function getLastItem(): int
    {
        if ($this->total === 0) {
            return 0;
        }

        return min($this->page * $this->perPage, $this->total);
    }
}
