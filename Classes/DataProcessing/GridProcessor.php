<?php

namespace Websight\WsTextmediaBootstrap\DataProcessing;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class GridProcessor
 *
 * @package Websight\WsTextmediaBootstrap\DataProcessing
 * @author Cedric Ziel <ziel@websight.de>
 */
class GridProcessor implements DataProcessorInterface
{
    /**
     * @var ContentObjectRenderer
     */
    protected $contentObjectRenderer;

    /**
     * The default configuration.
     * Additional configuration will be merged onto this field.
     *
     * @var array
     */
    protected $defaultProcessorConfiguration = [
        'bootstrap_grid_size' => '12'
    ];

    /**
     * Process content object data
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     *
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ) {
        $this->contentObjectRenderer = $cObj;

        if (isset($processorConfiguration['if.']) && !$this->contentObjectRenderer->checkIf($processorConfiguration['if.'])) {
            return $processedData;
        }

        $processorConfiguration = array_merge($this->defaultProcessorConfiguration, $processorConfiguration);

        $imageColumnSize = (int)$processedData['data']['ws_textmedia_bootstrap_image_size'];
        $imageColumnSizeLeftover = ($imageColumnSize ? (int)$processorConfiguration['bootstrap_grid_size'] - $imageColumnSize : 0);
        $imageColumnSizeLeftoverHalf = ($imageColumnSizeLeftover ? floor($imageColumnSizeLeftover / 2) : 0);

        $textColumnSize = (int)$processorConfiguration['bootstrap_grid_size'] - $imageColumnSize;

        $galleryColumnSize = floor((int)$processorConfiguration['bootstrap_grid_size'] / $processedData['gallery']['count']['columns']);

        $processedData['grid'] = [
            'classes' => [
                'textcol'  => ($textColumnSize ? 'col-md-' . $textColumnSize : 'col-md-12'),
                'imagecol' => ($imageColumnSize ? 'col-md-' . $imageColumnSize : 'col-md-12'),
                'imagecol_offset_leftover' => ($imageColumnSizeLeftover ? ' col-md-offset-' . $imageColumnSizeLeftover : ''),
                'imagecol_offset_leftover_half' => ($imageColumnSizeLeftoverHalf > 0 ? ' col-md-offset-' . $imageColumnSizeLeftoverHalf : ''),
                'gallerycol' => ($galleryColumnSize ? 'col-md-' . $galleryColumnSize : 'col-md-12')
            ],
            'wrap_element_uid' => $processorConfiguration['wrap_element_uid'],
            'max_image_width' => $processorConfiguration['max_image_width']
        ];

        return $processedData;
    }
}
