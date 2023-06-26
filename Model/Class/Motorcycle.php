<?php

class Motorcycle {
    private $id;
    private $marque_id;
    private $modele;
    private $type;
    private $image;

    public function __construct($id, $marque_id, $modele, $type, $image) {
        $this->id = $id;
        $this->marque_id = $marque_id;
        $this->modele = $modele;
        $this->type = $type;
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }

    public function getMarqueId() {
        return $this->marque_id;
    }

    public function getModele() {
        return $this->modele;
    }

    public function getType() {
        return $this->type;
    }

    public function getImage() {
        return $this->image;
    }
}
