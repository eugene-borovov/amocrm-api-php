<?php

declare(strict_types=1);

namespace AmoCRM\Models\CustomFields;

use AmoCRM\AmoCRM\Support\Collection;
use AmoCRM\Contracts\Support\Arrayable;

use function array_filter;
use function array_values;
use function is_array;

/**
 * Коллекция моделей вложенных списков
 *
 * @since Release Spring 2022
 * @template-extends Collection<ChainedList>
 */
final class ChainedLists extends Collection implements Arrayable, \JsonSerializable
{
    /**
     * @param array $items
     *
     * @return ChainedLists<ChainedList>
     */
    public static function fromArray(array $items)
    {
        $collection = new self();

        $items = array_filter(array_values($items), static function ($item) {
            return ! empty($item) && is_array($item);
        });

        if (empty($items)) {
            return $collection;
        }

        /** @var array $item */
        foreach ($items as $item) {
            $catalogId = (int) ($item['catalog_id'] ?? 0);
            $parentCatalogId = (int) ($item['parent_catalog_id'] ?? 0) ?: null;
            $title = (string) ($item['title'] ?? '');

            $collection[$catalogId] = new ChainedList($catalogId, $parentCatalogId, $title);
        }

        return $collection;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        return array_map(
            static function ($v) {
                return $v->toArray();
            },
            $this->items
        );
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
