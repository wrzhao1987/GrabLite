<?php
/**
 ** 時間が迫ってるんですから、このクラスはまだ実装してませんでした。
 **/
require_once ('Grab.class.php');
class GrabImage extends Grab
{
    public function __construct()
    {
        parent::__construct();
    }

    //Fetch the image url from url_queue in database
    public function fetch($url_list) {}

    //Filter the valid img src attribute
    public function filter($url_list) {}

    //Save the images to the local file system
    public function save($url_list) {}
}
