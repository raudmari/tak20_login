<?php

require_once 'models/RateBook.php';
require_once 'config/common.php';
require_once 'helpers/session_helper.php';

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


    public function userRateBooks()
    {
        $_POST = filter_input_array(INPUT_POST);
        $data = [
            'usersUid' => htmlspecialchars(trim($_POST['usersUid'])),
            'usersEmail' => htmlspecialchars(trim($_POST['usersEmail'])),
        ];

        $usresRB = $this->bookModel->userRatedBooks($data['usersUid'], $data['usersEmail']);
        if ($usresRB) {
            return $usresRB;
        } else {
            return false;
        }
    }

    public function setBooksValues()
    {
        $_POST = filter_input_array(INPUT_POST);

        $data = [
            'id' => htmlspecialchars(trim($_POST['id'])),
            'rating' => htmlspecialchars(trim($_POST['rating'])),
            'username' => htmlspecialchars(trim($_POST['username']))
        ];

        if ($this->bookModel->setBookValue($data)) {
            $result = 'OK';
        } else {
            $result = 'ERROR';
        }
    }
}

$init = new RateBooks;

$results = $init->rateBooks();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init->setBooksValues();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usresRB = $init->userRateBooks();
}

//show($usresRB);