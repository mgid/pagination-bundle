<?php declare(strict_types=1);

namespace Mgid\PaginationBundle\DependencyInjection;

use Mgid\Component\Pagination\Adapter;
use Mgid\Component\Pagination\Normalizer;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder(PaginationExtension::EXTENSION_ALIAS);

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $builder->getRootNode();

        $rootNode->children()->variableNode('adapters')->defaultValue($this->getAdapters())->end();
        $rootNode->children()->variableNode('normalizers')->defaultValue($this->getNormalizers())->end();

        return $builder;
    }

    /**
     * @return array<string,string>
     */
    private function getAdapters(): array
    {
        return [
            'Doctrine\ORM\QueryBuilder' => Adapter\Doctrine\ORM\QueryBuilderAdapter::class,
            'Doctrine\ODM\MongoDB\Query\Builder' => Adapter\Doctrine\ODM\QueryBuilderAdapter::class,
            'Doctrine\ODM\MongoDB\Aggregation\Builder' => Adapter\Doctrine\ODM\AggregationBuilderAdapter::class,
        ];
    }

    /**
     * @return array<string,array<int,string>>
     */
    private function getNormalizers(): array
    {
        return [
            'Doctrine\ORM\QueryBuilder' => [
                Normalizer\ORM\LikeNormalizer::class,
                Normalizer\ListNormalizer::class,
            ],
            'Doctrine\ODM\MongoDB\Query\Builder' => [
                Normalizer\ListNormalizer::class,
                Normalizer\FloatNormalizer::class,
                Normalizer\IntegerNormalizer::class,
            ],
            'Doctrine\ODM\MongoDB\Aggregation\Builder' => [
                Normalizer\ListNormalizer::class,
                Normalizer\FloatNormalizer::class,
                Normalizer\IntegerNormalizer::class,
            ],
        ];
    }
}
