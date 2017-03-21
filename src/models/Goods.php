<?php
/**
 * Date: 22.03.2017
 * Time: 20:45
 */

namespace Hector68\VkMarketExport\models;


class Goods implements GoodsInterface
{

    protected $id;

    protected $owner_id;

    protected $title;

    protected $description;

    protected $price;

    protected $category_id;

    protected $deleted;

    protected $main_photo_id;

    protected $photo_ids;

    /**
     * Goods constructor.
     * @param $id
     * @param $owner_id
     * @param $title
     * @param $description
     * @param $price
     * @param $category_id
     * @param $deleted
     * @param $main_photo_id
     * @param $photo_ids
     */
    public function __construct($id, $owner_id, $title, $description, $price, $category_id, $deleted, $main_photo_id, $photo_ids = [])
    {
        $this->id = $id;
        $this->owner_id = $owner_id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->deleted = $deleted;
        $this->main_photo_id = $main_photo_id;
        $this->photo_ids = $photo_ids;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return double
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return int
     */
    public function getMainPhotoId()
    {
        return $this->main_photo_id;
    }

    /**
     * @return array
     */
    public function getPhotoIds()
    {
        return $this->photo_ids;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @param mixed $main_photo_id
     */
    public function setMainPhotoId($main_photo_id)
    {
        $this->main_photo_id = $main_photo_id;
    }

    /**
     * @param array $photo_ids
     */
    public function setPhotoIds($photo_ids)
    {
        $this->photo_ids = $photo_ids;
    }


    

}