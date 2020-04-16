<?php

namespace Hatimeria\GtmEe\Model\DataLayerComponent;

use Magento\Quote\Model\Quote\Item;
use Hatimeria\GtmEe\Api\DataLayerComponentInterface;

/**
 * Class AddToCart
 * @package Hatimeria\GtmEe\Model\DataLayerComponent
 */
class AddToCart extends ComponentAbstract implements DataLayerComponentInterface
{

    const EVENT_NAME = 'add-to-cart';

    /**
     * @param Item $item
     */
    public function processProduct(Item $item)
    {
        $data = json_decode($this->checkoutSession->getGtmEeProductAddToCartData());
        if (!is_array($data)) {
            $data = [];
        }

        $product = $item->getProduct();
        $data[] = [
            'name' => $product->getName(),
            'id' => $product->getId(),
            'price' => $this->formatPrice($product->getFinalPrice()),
            'brand' => $this->getBrand($product),
            'category' => $this->getCategoryName($product),
            'variant' => $this->getVariant($item),
            'quantity' => $product->getQty()
        ];
        $this->checkoutSession->setGtmEeProductAddToCartData(json_encode($data));
    }

    public function getComponentData($eventData) {
        $data = [];
        $products = json_decode($this->checkoutSession->getGtmEeProductAddToCartData());
        if (is_array($products)) {
           $data['ecommerce'] = [
               'currencyCode' => $this->storeManager->getStore()->getCurrentCurrency()->getCode(),
               'add' => [
                   'actionField' => [
                       'list' => '',
                       'position' => ''
                   ],
                   'products' => $products
               ]
           ];

           $this->cleanSessionGtmProductAddToCartData();
        }

       return $data;
   }

    protected function cleanSessionGtmProductAddToCartData()
    {
        $this->checkoutSession->setGtmEeProductAddToCartData(false);
    }

    /**
     * @return string
     */
    protected function getEventName()
    {
        return self::EVENT_NAME;
    }
}
