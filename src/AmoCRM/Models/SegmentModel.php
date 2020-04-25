<?php

namespace AmoCRM\Models;

use AmoCRM\Collections\CustomFieldsValuesCollection;
use InvalidArgumentException;

class SegmentModel extends BaseApiModel
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $createdAt;

    /**
     * @var int
     */
    protected $updatedAt;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var int
     */
    protected $customersCount;

    /**
     * @var CustomFieldsValuesCollection
     */
    protected $customFieldsValues;

    /**
     * @var array
     */
    protected $availableProductsPriceTypes;

    /**
     * @var null|int
     */
    protected $requestId;

    /**
     * @param array $segment
     *
     * @return self
     */
    public static function fromArray(array $segment): self
    {
        if (empty($segment['id'])) {
            throw new InvalidArgumentException('Segment id is empty in ' . json_encode($segment));
        }

        $segmentModel = new self();

        $segmentModel
            ->setId($segment['id'])
            ->setName($segment['name'])
            ->setColor($segment['color']);

        if (!empty($segment['created_at'])) {
            $segmentModel->setCreatedAt($segment['created_at']);
        }

        if (!empty($segment['updated_at'])) {
            $segmentModel->setUpdatedAt($segment['updated_at']);
        }

        if (array_key_exists('customers_count', $segment) && !is_null($segment['customers_count'])) {
            $segmentModel->setCustomersCount($segment['customers_count']);
        }

        if (!empty($segment['available_products_price_types'])) {
            $segmentModel->setAvailableProductsPriceTypes($segment['available_products_price_types']);
        }

        if (!empty($segment['custom_fields_values'])) {
            $valuesCollection = new CustomFieldsValuesCollection();
            $customFieldsValues = $valuesCollection->fromArray($segment['custom_fields_values']);
            $segmentModel->setCustomFieldsValues($customFieldsValues);
        }

        return $segmentModel;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        $result = [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'color' => $this->getColor(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'customers_count' => $this->getCustomersCount(),
            'available_products_price_types' => $this->getAvailableProductsPriceTypes(),
            'custom_fields_values' => $this->getCustomFieldsValues(),
        ];

        return $result;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SegmentModel
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return SegmentModel
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int|null $requestId
     * @return array
     */
    public function toApi(int $requestId = null): array
    {
        $result = [];

        if (!is_null($this->getId())) {
            $result['id'] = $this->getId();
        }

        if (!is_null($this->getName())) {
            $result['name'] = $this->getName();
        }

        if (!is_null($this->getColor())) {
            $result['color'] = $this->getColor();
        }

        if (!is_null($this->getAvailableProductsPriceTypes())) {
            $result['available_products_price_types'] = $this->getAvailableProductsPriceTypes();
        }

        if (!is_null($this->getCustomFieldsValues())) {
            $result['custom_fields_values'] = $this->getCustomFieldsValues();
        }

        if (is_null($this->getRequestId()) && !is_null($requestId)) {
            $this->setRequestId($requestId + 1); //Бага в API не принимает 0
        }

        $result['request_id'] = $this->getRequestId();

        return $result;
    }

    /**
     * @return int|null
     */
    public function getRequestId(): ?int
    {
        return $this->requestId;
    }

    /**
     * @param int|null $requestId
     * @return SegmentModel
     */
    public function setRequestId(?int $requestId): self
    {
        $this->requestId = $requestId;

        return $this;
    }


    /**
     * @return null|int
     */
    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    /**
     * @param int $timestamp
     *
     * @return self
     */
    public function setCreatedAt(int $timestamp): self
    {
        $this->createdAt = $timestamp;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

    /**
     * @param int $timestamp
     *
     * @return self
     */
    public function setUpdatedAt(int $timestamp): self
    {
        $this->updatedAt = $timestamp;

        return $this;
    }


    public static function getAvailableWith(): array
    {
        return [];
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return SegmentModel
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return int
     */
    public function getCustomersCount(): int
    {
        return $this->customersCount;
    }

    /**
     * @param int $customersCount
     * @return SegmentModel
     */
    public function setCustomersCount(int $customersCount): self
    {
        $this->customersCount = $customersCount;

        return $this;
    }

    /**
     * @return CustomFieldsValuesCollection|null
     */
    public function getCustomFieldsValues(): ?CustomFieldsValuesCollection
    {
        return $this->customFieldsValues;
    }

    /**
     * @param CustomFieldsValuesCollection|null $values
     *
     * @return self
     */
    public function setCustomFieldsValues(?CustomFieldsValuesCollection $values): self
    {
        $this->customFieldsValues = $values;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getAvailableProductsPriceTypes(): ?array
    {
        return $this->availableProductsPriceTypes;
    }

    /**
     * @param array $availableProductsPriceTypes
     * @return SegmentModel
     */
    public function setAvailableProductsPriceTypes(array $availableProductsPriceTypes): self
    {
        $this->availableProductsPriceTypes = $availableProductsPriceTypes;

        return $this;
    }
}