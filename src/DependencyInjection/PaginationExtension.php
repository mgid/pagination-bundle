<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\DependencyInjection;

use Mgid\Component\Pagination\Paginator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class PaginationExtension extends ConfigurableExtension
{
    public const EXTENSION_ALIAS = 'sb_pagination';

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return self::EXTENSION_ALIAS;
    }

    /**
     * @param array<mixed>     $configs
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $configs, ContainerBuilder $container): void
    {
        $this->addPaginator($configs, $container);
    }

    /**
     * @param array<mixed>     $configs
     * @param ContainerBuilder $container
     */
    private function addPaginator(array $configs, ContainerBuilder $container): void
    {
        $paginator = new Definition(Paginator::class);
        $paginator->setPublic(true);
        $paginator->setAutowired(true);
        $paginator->setAutoconfigured(true);

        $this->addAdapters($configs, $paginator);
        $this->addNormalizers($configs, $paginator);

        $container->setDefinition(Paginator::class, $paginator);
    }

    /**
     * @param array<mixed> $configs
     * @param Definition   $paginator
     */
    private function addAdapters(array $configs, Definition $paginator): void
    {
        foreach ($configs['adapters'] as $queryBuilderClassName => $adapterClassName) {
            if (\class_exists($queryBuilderClassName)) {
                $paginator->addMethodCall('addAdapter', [$queryBuilderClassName, $adapterClassName]);
            }
        }
    }

    /**
     * @param array<mixed> $configs
     * @param Definition   $paginator
     */
    private function addNormalizers(array $configs, Definition $paginator): void
    {
        foreach ($configs['normalizers'] as $queryBuilderClassName => $normalizers) {
            foreach ($normalizers as $normalizerClassName) {
                $normalizer = new Definition($normalizerClassName);

                $paginator->addMethodCall('addNormalizer', [$queryBuilderClassName, $normalizer]);
            }
        }
    }
}
