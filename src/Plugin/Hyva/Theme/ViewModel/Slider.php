<?php
/**
 * @author    Sutunam
 * @copyright Copyright (c) 2024 Sutunam (http://www.sutunam.com/)
 */

declare(strict_types=1);

namespace Sutunam\HyvaLinkedProduct\Plugin\Hyva\Theme\ViewModel;

use Hyva\Theme\ViewModel\Store;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\Exception\NoSuchEntityException;
use Sutunam\LinkedProduct\Model\Config as ConfigData;
use Sutunam\LinkedProduct\ViewModel\ProductList;

class Slider
{
    /**
     * @var ProductList
     */
    protected ProductList $productList;

    /**
     * @var Store
     */
    protected $store;

    /**
     * @var ConfigData
     */
    protected $configData;

    /**
     * @param ProductList $productList
     * @param Store $store
     * @param ConfigData $configData
     */
    public function __construct(
        ProductList $productList,
        Store $store,
        ConfigData $configData
    ) {
        $this->productList = $productList;
        $this->store = $store;
        $this->configData = $configData;
    }

    /**
     * Before Get Slider For Items
     *
     * @param \Hyva\Theme\ViewModel\Slider $subject
     * @param string $itemTemplateFile
     * @param iterable $items
     * @param string $sliderTemplateFile
     * @return array
     * @throws NoSuchEntityException
     */
    public function beforeGetSliderForItems(
        \Hyva\Theme\ViewModel\Slider $subject,
        string $itemTemplateFile,
        iterable $items,
        string $sliderTemplateFile = 'Magento_Theme::elements/slider-php.phtml'
    ): array {
        if (!is_array($items) ||
            empty($items) ||
            !array_values($items)[0] instanceof \Magento\Catalog\Model\Product ||
            !$this->configData->isEnable() ||
            !$this->configData->isShowOnProductListing()
        ) {
            return [$itemTemplateFile, $items, $sliderTemplateFile];
        }

        if ($this->configData->isShowAvailableProductsCount()) {
            $linkedItemsSize = $this->productList->getLinkedItemsSize($items);

            if (count($linkedItemsSize) === 0) {
                return [$itemTemplateFile, $items, $sliderTemplateFile];
            }

            foreach (array_values($items) as $i => $product) {
                if (array_key_exists($product->getId(), $linkedItemsSize)) {
                    // +1 for parent product
                    $product->setData('available_products_count', $linkedItemsSize[$product->getId()] + 1);
                }
            }

            return [$itemTemplateFile, $items, $sliderTemplateFile];
        }

        $this->productList->addFilter('website_id', $this->store->getWebsiteId());
        $this->productList->addFilter('visibility', [
            Visibility::VISIBILITY_IN_CATALOG,
            Visibility::VISIBILITY_BOTH,
        ], 'in');

        $linkedCollection = $this->productList->getLinkedCollection($items);
        $linkedIds = $this->productList->getLinkedIds($items);

        $linkedProducts = [];

        foreach ($linkedIds as $item) {
            $linkedProduct = $linkedCollection->getItemById($item['linked_product_id']);
            if ($linkedProduct) {
                $linkedProducts[$item['product_id']][] =
                    $linkedCollection->getItemById($item['linked_product_id']);
            }
        }

        foreach ($items as $item) {
            if (array_key_exists($item->getId(), $linkedProducts)) {
                $item->setData('linked_products', $linkedProducts[$item->getId()]);
            }
        }

        return [$itemTemplateFile, $items, $sliderTemplateFile];
    }
}
