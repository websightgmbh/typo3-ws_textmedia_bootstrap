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
        'bootstrap_grid_size_xs' => '12',
        'bootstrap_grid_size_sm' => '12',
        'bootstrap_grid_size_md' => '12',
        'bootstrap_grid_size_lg' => '12'
    ];

    /**
     * @var int
     */
    protected $imgColSizeXs = null;

    /**
     * @var int
     */
    protected $imgColSizeSm = null;

    /**
     * @var int
     */
    protected $imgColSizeMd = null;

    /**
     * @var int
     */
    protected $imgColSizeLg = null;

    /**
     * @var array
     */
    protected $processorConfiguration;

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

        if (isset($processorConfiguration['if.'])
            && !$this->contentObjectRenderer->checkIf($processorConfiguration['if.'])
        ) {
            return $processedData;
        }

        $this->setProcessorConfiguration(array_merge($this->defaultProcessorConfiguration, $processorConfiguration));

        // set different sizes
        $this->setBreakPointSizes($processedData['data']);

        // Prevent division by zero
        if ((int)$processedData['gallery']['count']['columns'] <= 0) {
            $processedData['gallery']['count']['columns'] = 1;
        }
        $galleryColumnSize = floor(
            (int)$this->getProcessorConfiguration()['bootstrap_grid_size']
            / $processedData['gallery']['count']['columns']
        );


        $processedData['grid'] = [
            'classes' => [
                'textcol' => $this->getTextColSizes(),
                'imagecol' => $this->getImgColSizes(),
                'imagecol_offset_leftover' => $this->getImgOffsetLeftOver(),
                'imagecol_offset_leftover_half' => $this->getImgOffsetLeftOverHalf(),
                'gallerycol' => ($galleryColumnSize ? 'col-xs-' . $galleryColumnSize : 'col-xs-12')
            ],
            'wrap_element_uid' => $processorConfiguration['wrap_element_uid'],
            'max_image_width' => $processorConfiguration['max_image_width']
        ];
        return $processedData;
    }

    protected function setBreakPointSizes($cObjData)
    {
        // set different sizes
        $this->setImgColSizeXs(intval($cObjData['ws_textmedia_bootstrap_image_size_xs']));
        $this->setImgColSizeSm(intval($cObjData['ws_textmedia_bootstrap_image_size_sm']));
        $this->setImgColSizeMd(intval($cObjData['ws_textmedia_bootstrap_image_size_md']));
        $this->setImgColSizeLg(intval($cObjData['ws_textmedia_bootstrap_image_size_lg']));
    }

    /**
     * returns the bootstrap offset class for a image on each breakpoint
     * is used for images positioned right
     * @return string
     */
    protected function getImgOffsetLeftOver()
    {
        // get image offset for each breakpoint
        $imgColSizeOffsets = $this->getImgOffsets();

        $imgOffsetReturnClassArr = [];
        foreach ($imgColSizeOffsets as $key => $value) {
            $imgOffsetReturnClassArr[$key] = ($value ? ' col-' . $key . '-offset-' . $value : '');
        }
        return implode(' ', $imgOffsetReturnClassArr);
    }

    /**
     * returns the bootstrap offset class for a image on each breakpoint
     * is used for images positioned centered
     * @return string
     */
    protected function getImgOffsetLeftOverHalf()
    {
        // get image offset for each breakpoint
        $imgColSizeOffsets = $this->getImgOffsets();

        $imgOffsetHalfReturnClassArr = [];
        foreach ($imgColSizeOffsets as $key => $value) {
            $imgColSizeLeftoverHalf = ($value ? floor($value / 2) : 0);
            $imgOffsetHalfReturnClassArr[$key] = ($imgColSizeLeftoverHalf > 0
                ? ' col-' . $key . '-offset-' . $imgColSizeLeftoverHalf
                : ''
            );
        }
        return implode(' ', $imgOffsetHalfReturnClassArr);
    }

    /**
     * return the offset for each image and breakpoint
     * @return array
     */
    protected function getImgOffsets()
    {
        $imgColSizeXs = ($this->getImgColSizeXs() > 0) ? $this->getImgColSizeXs() : 0;
        $imgColSizeSm = ($this->getImgColSizeSm() > 0) ? $this->getImgColSizeSm() : 0;
        $imgColSizeMd = ($this->getImgColSizeMd() > 0) ? $this->getImgColSizeMd() : 0;
        $imgColSizeLg = ($this->getImgColSizeLg() > 0) ? $this->getImgColSizeLg() : 0;


        return [
            'xs' => ($imgColSizeXs
                ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeXs
                : 0
            ),
            'sm' => ($imgColSizeSm
                ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeSm
                : 0
            ),
            'md' => ($imgColSizeMd
                ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeMd
                : 0
            ),
            'lg' => ($imgColSizeLg
                ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeLg
                : 0
            ),
        ];
    }

    /**
     * get calculated text size as bootstrap class for each breakpoint
     * @return string
     */
    protected function getTextColSizes()
    {
        $imgColSizeXs = ($this->getImgColSizeXs() > 0) ? $this->getImgColSizeXs() : 12;
        $imgColSizeSm = ($this->getImgColSizeSm() > 0) ? $this->getImgColSizeSm() : 0;
        $imgColSizeMd = ($this->getImgColSizeMd() > 0) ? $this->getImgColSizeMd() : 0;
        $imgColSizeLg = ($this->getImgColSizeLg() > 0) ? $this->getImgColSizeLg() : 0;

        $textColumnSizeXs = (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeXs;
        $textColumnSizeSm = $imgColSizeSm
            ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeSm
            : '';
        $textColumnSizeMd =  $imgColSizeMd
            ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeMd
            : '';
        $textColumnSizeLg =  $imgColSizeLg
            ? (int)$this->getProcessorConfiguration()['bootstrap_grid_size'] - $imgColSizeLg
            : '';

        $textColSizeArr = [
            'xs' => ($textColumnSizeXs ? 'col-xs-' . $textColumnSizeXs : 'col-xs-12'),
            'sm' => ($textColumnSizeSm ? 'col-sm-' . $textColumnSizeSm : ''),
            'md' => ($textColumnSizeMd ? 'col-md-' . $textColumnSizeMd : ''),
            'lg' => ($textColumnSizeLg ? 'col-lg-' . $textColumnSizeLg : '')
        ];
        return implode(' ', $textColSizeArr);
    }

    /**
     * get image size as bootstrap class for each breakpoint
     * @return string
     */
    protected function getImgColSizes()
    {
        $imgColSizeArr = [
            'xs' => $this->getImgColSizeXs()> 0
                ? 'col-xs-' . $this->getImgColSizeXs()
                : ($this->getImgColSizeXs() == -1 ? 'hidden-xs' : 'col-xs-12'),
            'sm' => $this->getImgColSizeSm() > 0
                ? 'col-sm-' . $this->getImgColSizeSm()
                : ($this->getImgColSizeSm() == -1 ? 'hidden-sm' : ''),
            'md' => $this->getImgColSizeMd() > 0
                ? 'col-md-' . $this->getImgColSizeMd()
                : ($this->getImgColSizeMd() == -1 ? 'hidden-md' : ''),
            'lg' => $this->getImgColSizeLg() > 0
                ? 'col-lg-' . $this->getImgColSizeLg()
                : ($this->getImgColSizeLg() == -1 ? 'hidden-lg' : '')
        ];
        return implode(' ', $imgColSizeArr);
    }

    /**
     * @return array
     */
    public function getProcessorConfiguration()
    {
        return $this->processorConfiguration;
    }

    /**
     * @param array $processorConfiguration
     */
    public function setProcessorConfiguration($processorConfiguration)
    {
        $this->processorConfiguration = $processorConfiguration;
    }

    /**
     * @return int
     */
    public function getImgColSizeXs()
    {
        return $this->imgColSizeXs;
    }

    /**
     * @param int $imgColSizeXs
     */
    public function setImgColSizeXs($imgColSizeXs)
    {
        $this->imgColSizeXs = $imgColSizeXs;
    }

    /**
     * @return int
     */
    public function getImgColSizeSm()
    {
        return $this->imgColSizeSm;
    }

    /**
     * @param int $imgColSizeSm
     */
    public function setImgColSizeSm($imgColSizeSm)
    {
        $this->imgColSizeSm = $imgColSizeSm;
    }

    /**
     * @return int
     */
    public function getImgColSizeMd()
    {
        return $this->imgColSizeMd;
    }

    /**
     * @param int $imgColSizeMd
     */
    public function setImgColSizeMd($imgColSizeMd)
    {
        $this->imgColSizeMd = $imgColSizeMd;
    }

    /**
     * @return int
     */
    public function getImgColSizeLg()
    {
        return $this->imgColSizeLg;
    }

    /**
     * @param int $imgColSizeLg
     */
    public function setImgColSizeLg($imgColSizeLg)
    {
        $this->imgColSizeLg = $imgColSizeLg;
    }
}
