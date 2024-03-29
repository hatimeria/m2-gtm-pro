<?php
/**
 * @category   Hatimeria
 * @author      (office@hatimeria.com)
 * @copyright  Copyright (c) 2020 Hatimeria Sp. z o.o. Sp. k. ( https://www.hatimeria.com/ )
 * @license    (https://www.gnu.org/licenses/gpl-3.0.html)
 */

namespace Hatimeria\GtmPro\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Hatimeria\GtmPro\Model\Config;
use Hatimeria\GtmPro\Model\DataLayerComponent\RemoveProductFromCompare as RemoveProductFromCompareComponent;

/**
 * Class RemoveProductFromCompare
 */
class RemoveProductFromCompare implements ObserverInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var RemoveProductFromCompareComponent
     */
    private $removeProductFromCompareComponent;

    /**
     * RemoveProductFromCompare constructor.
     * @param Config $config
     * @param RemoveProductFromCompareComponent $removeProductFromCompareComponent
     */
    public function __construct(
        Config $config,
        RemoveProductFromCompareComponent $removeProductFromCompareComponent
    ) {
        $this->config = $config;
        $this->removeProductFromCompareComponent = $removeProductFromCompareComponent;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        if ($this->config->isModuleEnabled() && $this->config->isAddToCompareTrackingEnabled()) {
            /** @var \Magento\Catalog\Model\Product\Compare\Item $product */
            $product = $observer->getProduct();
            $this->removeProductFromCompareComponent->processData(['product_id' => $product->getProductId()]);
        }

        return $this;
    }
}
