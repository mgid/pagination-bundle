<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\Tests\Fixtures\Service;

use Mgid\PaginationBundle\DependencyInjection\PaginatorTrait;

final class SecondService
{
    use PaginatorTrait;

    protected function getSortableFields(): array
    {
        return ['foo'];
    }

    protected function getFilterableFields(): array
    {
        return ['baz'];
    }

    protected function getFieldsAssociations(): array
    {
        return ['one' => 'two'];
    }
}
