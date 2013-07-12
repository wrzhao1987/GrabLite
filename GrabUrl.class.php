<?php
require_once ('Grab.class.php');
class GrabUrl extends Grab
{
    public function __construct()
    {
        parent::__construct();
    }

    //Fetch the urls
    public function fetch($feed_url, $turns='')
    {
        if (is_array($feed_url))
        {
            if (empty($turns))
            {
                global $config;
                $turns = $config['url_get_turns'];
            }
            for ($i = 1; $i <= $turns; $i ++)
            {
                $list = array();
                foreach ($feed_url as $url)
                {
                    $delta = array();
                    if ( ! self::verifyExtesion($url) )
                    {
                        continue;
                    }
                    echo "Fetching $url.\n";
                    $page = file_get_contents($url);
                    if ( !empty($page))
                    {
                        $href_regex = '%<a[\s\S]*?href="([^"]+)[^>]+>([\s\S]*?)</a>%';
                        preg_match_all($href_regex, $page, $delta, PREG_PATTERN_ORDER);
                        $delta = $this->filter($delta);
                        $list = array_merge($delta, $list);
                        $list = array_unique($list);
                    }
                }
                $this->save($list);
                $feed_url = $list;
                echo "$i round completed.\n";
            }
        }
        echo "Done.\n";
    }
    // Filter the unused file extension name
    private static function verifyExtesion($url)
    {
        $ext = substr(strrchr($url, '.'), 1);
        return in_array ($ext, array('pdf', 'exe', 'dmg', 'pkg', 'mp3', 'mp4', 'rar', 'zip') ) ? false : true;
    }

    protected function filter($href_res)
    {
        if (empty($href_res))
        {
            return array();;
        }
        $filter_result = array();
        $count = count($href_res);
        if ( ! empty($href_res[1]) )
        {
            foreach ($href_res[1] as $key => $url)
            {
                if (substr($url, 0, 4) == 'http')
                {
                   $filter_result[] = $url;
                }
            }
        }
        return $filter_result;
    }

    // Save the url list to the database.
    protected function save($url_list)
    {
        $db = My_MySQL::getInstance();
        foreach ($url_list as $url)
        {
            $db->insertUrl($url);
        }
    }
}
