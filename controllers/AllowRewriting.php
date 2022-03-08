<?php

require_once 'models/AllowRewrite.php';
require_once 'helpers/session_helper.php';
require_once 'config/common.php';


class AllowRewriting
{

    private $rewriteModel;

    public function __construct()
    {
        $this->rewriteModel = new AllowRewrite;
    }

    function isRewriteAllowed()
    {
        $row = $this->rewriteModel->rewriteAllowed();
        define('ALLOW_REWRITE', $row->allow);
        if (ALLOW_REWRITE) {
            return true;
        } else {
            return false;
        }
    }

    function allowSettings()
    {
        $_POST = filter_input_array(INPUT_POST);

        $data = [
            'allow' => htmlspecialchars(trim($_POST['allow'])),
            'id' => htmlspecialchars(trim($_POST['id']))
        ];

        if ($this->rewriteModel->setAllow($data['allow'], $data['id'])) {
            $result = 'OK';
        } else {
            $result = 'ERROR';
        }
    }
}

$init = new AllowRewriting;

$allow = $init->isRewriteAllowed();

$rateSettings = $init->allowSettings();