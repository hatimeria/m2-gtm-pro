<?php
/**
 * @category   Hatimeria
 * @author      (office@hatimeria.com)
 * @copyright  Copyright (c) 2020 Hatimeria Sp. z o.o. Sp. k. ( https://www.hatimeria.com/ )
 * @license    (https://www.gnu.org/licenses/gpl-3.0.html)
 */

namespace Hatimeria\GtmPro\Model\DataLayerComponent;

use Magento\Quote\Model\Quote\Item;
use Hatimeria\GtmPro\Api\DataLayerComponentInterface;

/**
 * Class AddToCart
 */
class AddToCart extends ComponentAbstract implements DataLayerComponentInterface
{
    const EVENT_NAME = 'add-to-cart';

    /**
     * @param Item $item
     */
    public function processProduct(Item $item)
    {
        $data = json_decode((string)$this->checkoutSession->getGtmProProductAddToCartData());
        if (!is_array($data)) {
            $data = [];
        }

        $product = $item->getProduct();
        $data[] = array_merge($this->getProductStructure($product, false), [
            'variant' => $this->getVariant($item),
            'quantity' => $item->getQty()
        ]);
        $this->checkoutSession->setGtmProProductAddToCartData(json_encode($data));
    }

    /**
     * @param $eventData
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getComponentData($eventData)
    {
        $data = [];
        $products = json_decode((string)$this->checkoutSession->getGtmProProductAddToCartData());
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

    /**
     * @return void
     */
    protected function cleanSessionGtmProductAddToCartData()
    {
        $this->checkoutSession->setGtmProProductAddToCartData(false);
    }

    /**
     * @return string
     */
    protected function getEventName()
    {
        return self::EVENT_NAME;
    }
}
