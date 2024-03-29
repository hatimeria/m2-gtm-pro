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
use Hatimeria\GtmPro\Model\DataLayerComponent\AddProductToWishlist as AddProductToWishlistComponent;

/**
 * Class AddProductToWishlist
 */
class AddProductToWishlist implements ObserverInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var AddProductToWishlistComponent
     */
    private $addProductToWishlistComponent;

    /**
     * AddProductToWishlist constructor.
     * @param Config $config
     * @param AddProductToWishlistComponent $addProductToWishlistComponent
     */
    public function __construct(
        Config $config,
        AddProductToWishlistComponent $addProductToWishlistComponent
    ) {
        $this->config = $config;
        $this->addProductToWishlistComponent = $addProductToWishlistComponent;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        if ($this->config->isModuleEnabled() && $this->config->isAddToWishlistTrackingEnabled()) {
            $this->addProductToWishlistComponent->processProduct($observer->getProduct());
        }

        return $this;
    }
}
