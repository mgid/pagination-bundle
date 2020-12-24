<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\Tests;

final class Kernel
{
    /**
     * @var Fixtures\app\AppKernel
     */
    private static Fixtures\app\AppKernel $instance;

    /**
     * @return Fixtures\app\AppKernel
     */
    public static function make(): Fixtures\app\AppKernel
    {
        static::$instance = new Fixtures\app\AppKernel('test', true);
        static::$instance->boot();

        return static::$instance;
    }
}
