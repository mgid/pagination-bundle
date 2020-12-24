<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\Tests\DependencyInjection;

use Mgid\Component\Pagination\Paginator;
use Mgid\PaginationBundle\Tests\TestCase;
use Mgid\PaginationBundle\Tests\Fixtures\Service;

final class PaginatorTraitTest extends TestCase
{
    public function testPaginatorInjection(): void
    {
        $paginator = $this->container->get(Paginator::class);

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('foo'));
        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('baz'));

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('baz'));
        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('foo'));

        $this->container->get(Service\FirstService::class);

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('foo'));
        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('baz'));

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('baz'));
        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('foo'));
    }

    public function testPaginatorInjectionWithSortableAndFilterableFields(): void
    {
        $paginator = $this->container->get(Paginator::class);

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('foo'));
        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('baz'));

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('baz'));
        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('foo'));

        $this->container->get(Service\SecondService::class);

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedOrder('foo'));
        $this->assertFalse($paginator->getMapping()->getConstraint()->isAllowedOrder('baz'));

        $this->assertTrue($paginator->getMapping()->getConstraint()->isAllowedFilter('baz'));
        $this->assertFalse($paginator->getMapping()->getConstraint()->isAllowedFilter('foo'));
    }
}
