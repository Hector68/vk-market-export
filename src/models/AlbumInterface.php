<?php
/**
 * Date: 28.03.2017
 * Time: 21:08
 */

namespace Hector68\VkMarketExport\models;


interface AlbumInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getOwnerId();

    /**
     * @param int $owner_id
     */
    public function setOwnerId($owner_id);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return int
     */
    public function getPhotoId();

    /**
     * @param int $photo_id
     */
    public function setPhotoId($photo_id);

    /**
     * @return boolean
     */
    public function isMainAlbum();

    /**
     * @param boolean $main_album
     */
    public function setMainAlbum($main_album);
}