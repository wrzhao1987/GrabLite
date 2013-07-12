<?php
class My_MySQL
{
    public $connection = null;
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
        global $config;
        $pdo_config = $config['pdo_config'];
        try {
            $this->connection = new PDO($pdo_config['dsn'],
                                        $pdo_config['username'],
                                        $pdo_config['password'],
                                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$pdo_config['charset']}"));
        } catch (PDOException $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
        }
    }

    public function insertUrl($url)
    {
        if ( !empty($url) && is_string($url) )
        {
            $url_hash = md5($url);
        }
        $add_time = time();
        $sql = "INSERT IGNORE INTO url_queue SET `url_hash`=?, `url_content`=?";
        $sth = $this->connection->prepare($sql);
        $result = $sth->execute(array($url_hash, $url));
        return $result;
    }

    public function updateUrlStatus($url_hash, $status)
    {
        if ( empty($url_hash) || !is_string($url_hash) )
        {
            $update_time = time();
            $sql = "UPDATE url_queue
                    SET `status`=?, `update_time`=?
                    WHERE `url_hash`=?";
            $sth = $this->connection->prepare($sql);
            $result = $sth->execute(array($status, $update_time, $url_hash));
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function getUrls($num)
    {
        if ($num == 'all')
        {
            $sql = "SELECT id, url_hash, url_content, status
                FROM url_queue
                WHERE status = 0";
            $sth = $this->connection->prepare($sql);
            $sth->execute();
        }
        else if (intval($num) > 0)
        {
            $sql = "SELECT `id`, `url_hash`, `url_content`, `status`
                FROM `url_queue`
                WHERE `status` = 0
                LIMIT ?";
            $sth = $this->connection->prepare($sql);
            $sth->execute(array($num));
        }
        $result = $sth->fetchAll();
        return $result;
    }
}
