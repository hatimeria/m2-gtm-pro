<?php
/**
 * @category   Hatimeria
 * @author      (office@hatimeria.com)
 * @copyright  Copyright (c) 2020 Hatimeria Sp. z o.o. Sp. k. ( https://www.hatimeria.com/ )
 * @license    (https://www.gnu.org/licenses/gpl-3.0.html)
 */

namespace Hatimeria\GtmPro\Model\DataLayerComponent;

use Hatimeria\GtmPro\Model\Config;

/**
 * Class ProductView
 */
class ProductView extends AbstractComponent
{
    protected \Hatimeria\GtmPro\Model\UA\DataLayerComponent\ProductView $productViewUa;
    protected \Hatimeria\GtmPro\Model\V4\DataLayerComponent\ProductView $productView4;

    public function __construct(
        Config $config,
        \Hatimeria\GtmPro\Model\UA\DataLayerComponent\ProductView $productViewUa,
        \Hatimeria\GtmPro\Model\V4\DataLayerComponent\ProductView $productView4
    )
    {
        parent::__construct($config);
        $this->productViewUa = $productViewUa;
        $this->productView4 = $productView4;
    }

    /**
     * @param $eventData
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getComponentData($eventData)
    {
        $system = $this->isGoogleAnalytics4() ? $this->productView4 : $this->productViewUa;

        return $system->getComponentData($eventData);
    }
}
