<?php
abstract class Grab
{
    protected $img_dir_prefix = '';

    public function __construct()
    {
        global $config;
        $this->img_dir_prefix = $config['img_dir_prefix'];
    }

    protected function fetchDOM($url, $xpath, $attr)
    {
        if (empty($url) || empty($xpath))
        {
            return false;
        }
		$ch  = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$return = curl_exec($ch);
		$html_doc = new DOMDocument();
		$html_doc->normalizeDocument();
		$html_doc->loadHTML($return);
		$xpath = new DOMXPath($html_doc);
		$elements = $xpath->query($xpath);
		if (!is_null($elements))
		{
            for ($i = 0; $i < $elements->length; $i++)
            {
                $item = $elements->item($i);
                $result [] = $item->getAttributeNode($attr)->value;
            }
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function fetch($url_list='') {}

    protected function filter($url_list='') {}

    protected function save($url_list='') {}
}
