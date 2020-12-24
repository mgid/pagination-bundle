<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\DependencyInjection;

use Mgid\Component\Pagination\Paginator;

trait PaginatorTrait
{
    protected Paginator $paginator;

    /**
     * @required
     *
     * @param Paginator $paginator
     */
    public function setPaginator(Paginator $paginator): void
    {
        $this->paginator = $paginator;

        $this->paginator->getMapping()->setAssociations($this->getFieldsAssociations());
        $this->paginator->getMapping()->getConstraint()->setOrders($this->getSortableFields());
        $this->paginator->getMapping()->getConstraint()->setFilters($this->getFilterableFields());
    }

    /**
     * @return string[]
     */
    protected function getSortableFields(): array
    {
        return [];
    }

    /**
     * @return string[]
     */
    protected function getFilterableFields(): array
    {
        return [];
    }

    /**
     * @return array<string,string>
     */
    protected function getFieldsAssociations(): array
    {
        return [];
    }
}
