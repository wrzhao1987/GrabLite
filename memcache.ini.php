<?php
class My_Memcached
{
    private $connection = null;
    private static $_instance = null;

    public static function getInstance()
    {
        if ( ! (self::$_instance instanceof self) )
        {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    private function __construct ()
    {
        require_once ('config.ini.php');
        $server_list = $config['memcached_servers'];
        $this->connection = new memcached();
        if ( ! empty($server_list) && is_array($server_list) )
        {
            foreach ($server_list as $server)
            {
                $this->connection->addServer($server['host'], $server['port'], $server['weight']);
            }
        }
    }

    public function addUrl($url)
    {
        if ( is_string($url) && ! empty($url) )
        {
            $url_hash = md5($url);
        }
        $is_new_key = $this->connection->add($url_hash, $url, 0);
        return $is_new_key;
    }

    public function popOneUrl()
    {
    }
}
