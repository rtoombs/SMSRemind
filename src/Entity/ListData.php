<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ListDataRepository")
 */
class ListData
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId() {
        return $this->id;
    }

    /**
     * @ORM\Column(type="integer")
     */
    private $uid;

    /**
     * @ORM\Column(type="text")
     */
    private $data;

    /**
     * @ORM\Column(type="datetimetz")
     * @ORM\GeneratedValue()
     */
    private $modified;

    //Get and Set
    public function getUid(){
        return $this->uid;
    }
    public function setUid($uid){
        $this->uid = $uid;
    }
    public function getData() {
        return $this->data;
    }
    public function setData($data) {
        $this->data = $data;
    }
    public function getModified() {
        return $this->modified;
    }
    public function setModified($modified) {
        $this->modified = $modified;
    }

}
