<?php

/*
 * Author: Roland Kluge
 */

final class BookEntry {

    private $id;
    private $amount;
    private $date;
    private $user;
    private $book;
    private $description;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    /**
     * @return DateTime the date of this entry
     */
    public function getDate() {
        return $this->date;
    }
    
    public function getFormattedDate() {
        return $this->date->format("d.m.Y");
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function getBook() {
        return $this->book;
    }

    public function setBook($book) {
        $this->book = $book;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public static function compareByDateRevers(BookEntry $e1, BookEntry $e2) {
        $t1 = $e1->getDate()->getTimestamp();
        $t2 = $e2->getDate()->getTimestamp();
        
        return -($t1 - $t2);
    }

}
