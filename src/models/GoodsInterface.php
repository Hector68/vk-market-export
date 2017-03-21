<?php
/**
 * Date: 22.03.2017
 * Time: 20:46
 */

namespace Hector68\VkMarketExport\models;


interface GoodsInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getOwnerId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return double
     */
    public function getPrice();

    /**
     * @return int
     */
    public function getCategoryId();

    /**
     * @return int
     */
    public function getDeleted();

    /**
     * @return int
     */
    public function getMainPhotoId();

    /**
     * @return array
     */
    public function getPhotoIds();
}