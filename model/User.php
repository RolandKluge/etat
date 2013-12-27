<?php

/**
 * Represents a user
 *
 * @author Roland Kluge
 */
final class User {

    private $id;
    private $name;
    private $isReal;

    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = (int)$id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    
    public function isReal() {
        return $this->isReal;
    }
    
    public function setIsReal($isReal) {
        $this->isReal = $isReal;
    }
    
}
