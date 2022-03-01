<?php

require_once 'models/RateBook.php';
require_once 'config/common.php';

class RateBooks
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = new RateBook;
    }

    public function rateBooks()
    {
        $results = $this->bookModel->ratedBooks();

        if ($results) {
            return $results;
        } else {
            return false;
        }
    }

    public function setBooksValues()
    {
        $_POST = filter_input_array(INPUT_POST);

        $data = [
            'book_id' => htmlspecialchars(trim($_POST['book_id'])),
            'rating' => htmlspecialchars(trim($_POST['rating'])),
            'username' => htmlspecialchars(trim($_POST['username']))
        ];

        if ($this->bookModel->setBookValue($data['book_id'], $data['rating'], $data['username'])) {
            $result = 'OK';
        } else {
            $result = 'ERROR';
        }
    }
}

$init = new RateBooks;

$results = $init->rateBooks();

//  $setBooksValues = $init->setBooksValues();

//show($results);