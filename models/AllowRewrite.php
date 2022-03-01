<?php
require_once '/home/marionraudsepp/public_html/tak20_login_edit/libraries/Database.php';


class AllowRewrite
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function rewriteAllowed()
    {
        $this->db->query('SELECT * FROM settings ORDER BY id LIMIT 1');
        $row = $this->db->singleone();
        if ($row) {
            return $row;
        } else {
            return false;
        }
    }

    public function setAllow($allow, $id)
    {
        $this->db->query('UPDATE settings SET allow = :allow WHERE id = :id');
        $this->db->bind(':allow', $allow);
        $this->db->bind(':id', $id);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
