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
}

$init = new RateChildMouths;

$results = $init->ratedMouth();