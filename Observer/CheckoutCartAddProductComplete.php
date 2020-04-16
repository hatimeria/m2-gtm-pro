<?php

namespace Hatimeria\GtmEe\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Session;
use Magento\Framework\Event\Observer;
use Hatimeria\GtmEe\Model\Config;
use Hatimeria\GtmEe\Model\DataLayerComponent\AddToCart;

class CheckoutCartAddProductComplete implements ObserverInterface
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Session
     */
    private $checkoutSession;

    /**
     * @var AddToCart
     */
    private $addToCartComponent;

    public function __construct(
        Config $config,
        Session $checkoutSession,
        AddToCart $addToCartComponent
    ) {
        $this->config = $config;
        $this->checkoutSession = $checkoutSession;
        $this->addToCartComponent = $addToCartComponent;
    }

    /**
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        if (!$this->config->isModuleEnabled() && !$this->config->isAddToCartTrackingEnabled()) {
            return $this;
        }

        $product = $observer->getData('product');
        $quote = $this->checkoutSession->getQuote();
        $item = $quote->getItemByProduct($product);

        $this->addToCartComponent->processProduct($item);

        return $this;
    }
}