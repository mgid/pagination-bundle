<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\Tests\DependencyInjection;

use Mgid\Component\Pagination\Paginator;
use Mgid\PaginationBundle\Tests\TestCase;

final class PaginationExtensionTest extends TestCase
{
    public function testPaginatorInjection(): void
    {
        $this->assertTrue($this->container->has(Paginator::class));
    }
}
