<?php

require_once 'models/RateChildMouth.php';

class RateChildMouths
{
    private $bookModel;

    public function __construct()
    {
        $this->childModel = new RateChildMouth;
    }

    public function ratedMouth()
    {
        $results = $this->childModel->ratedChildMouth();

        if ($results) {
            return $results;
        } else {
            return false;
        }
    }

    public function setChildsValues()
    {
        $_POST = filter_input_array(INPUT_POST);

        $data = [
            'id' => htmlspecialchars(trim($_POST['id'])),
            'rating' => htmlspecialchars(trim($_POST['rating'])),
            'username' => htmlspecialchars(trim($_POST['username']))
        ];

        if ($this->childModel->setChildValue($data)) {
            $result = 'OK';
        } else {
            $result = 'ERROR';
        }
    }
}

$init = new RateChildMouths;

$results = $init->ratedMouth();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $init->setChildsValues();
}
