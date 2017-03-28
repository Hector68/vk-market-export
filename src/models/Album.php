<?php
/**
 * Date: 28.03.2017
 * Time: 21:07
 */

namespace Hector68\VkMarketExport\models;


/**
 * Class Album
 * @package Hector68\VkMarketExport\models
 */
class Album implements AlbumInterface
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $owner_id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var int
     */
    protected $photo_id;

    /**
     * @var bool
     */
    protected $main_album;

    /**
     * Album constructor.
     * @param int $id
     * @param int $owner_id
     * @param string $title
     * @param int $photo_id
     * @param bool $main_album
     */
    public function __construct($owner_id, $title, $photo_id = null, $main_album = null, $id = null)
    {
        $this->id = $id;
        $this->owner_id = $owner_id;
        $this->title = $title;
        $this->photo_id = $photo_id;
        $this->main_album = $main_album;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->owner_id;
    }

    /**
     * @param int $owner_id
     */
    public function setOwnerId($owner_id)
    {
        $this->owner_id = $owner_id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getPhotoId()
    {
        return $this->photo_id;
    }

    /**
     * @param int $photo_id
     */
    public function setPhotoId($photo_id)
    {
        $this->photo_id = $photo_id;
    }

    /**
     * @return boolean
     */
    public function isMainAlbum()
    {
        return $this->main_album;
    }

    /**
     * @param boolean $main_album
     */
    public function setMainAlbum($main_album)
    {
        $this->main_album = $main_album;
    }


}