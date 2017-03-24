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

    /**
     * @param mixed $id
     */
    public function setId($id);

    /**
     * @param mixed $owner_id
     */
    public function setOwnerId($owner_id);

    /**
     * @param mixed $title
     */
    public function setTitle($title);

    /**
     * @param mixed $description
     */
    public function setDescription($description);

    /**
     * @param mixed $price
     */
    public function setPrice($price);

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id);

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted);

    /**
     * @param mixed $main_photo_id
     */
    public function setMainPhotoId($main_photo_id);

    /**
     * @param array $photo_ids
     */
    public function setPhotoIds($photo_ids);
}