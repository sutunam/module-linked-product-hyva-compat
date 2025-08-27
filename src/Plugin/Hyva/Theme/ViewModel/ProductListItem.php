<?php
/**
 * @author    Sutunam
 * @copyright Copyright (c) 2024 Sutunam (http://www.sutunam.com/)
 */

declare(strict_types=1);

namespace Sutunam\HyvaLinkedProduct\Plugin\Hyva\Theme\ViewModel;

use Hyva\Theme\ViewModel\CurrentProduct;

class ProductListItem
{
    /**
     * @var CurrentProduct
     */
    private $currentProduct;

    /**
     * @param CurrentProduct $currentProduct
     */
    public function __construct(CurrentProduct $currentProduct)
    {
        $this->currentProduct = $currentProduct;
    }

    /**
     * After get item cache key info
     *
     * @param \Hyva\Theme\ViewModel\ProductListItem $subject
     * @param array $result
     * @return array
     */
    public function afterGetItemCacheKeyInfo(
        \Hyva\Theme\ViewModel\ProductListItem $subject,
        array $result
    ): array {
        $currentProductId = $this->currentProduct->exists() ? $this->currentProduct->get()->getId() : '0';
        array_push($result, $currentProductId);
        return $result;
    }
}
