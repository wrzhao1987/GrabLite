<?php
require_once ('Grab.class.php');
class GrabImage extends Grab
{
    public function __construct()
    {
        parent::__construct();
    }

    public function fetch($url_list) {}

    public function filter($url_list) {}

    public function save($url_list) {}
}
