<?php

namespace Hatimeria\GtmEe\Block\Event;

use Magento\Framework\View\Element\Template;
use Hatimeria\GtmEe\Model\Config;

/**
 * Class Tag
 */
class ProductImpression extends AbstractEvent
{
    /**
     * @return bool
     */
    public function isEventEnabled()
    {
        return $this->config->isProductImpressionTrackingEnabled();
    }

    /**
     * @return string
     */
    public function getProductClass()
    {
        return $this->config->getProductImpressionTrackClass();
    }
}
