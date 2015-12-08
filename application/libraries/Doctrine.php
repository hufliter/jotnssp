<?php
use Doctrine\Common\ClassLoader;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine
{
    protected $em;

    protected static $instance;

    protected function __construct()
    {
        include dirname(APPPATH) . '/detect_env.php';
        if (ENVIRONMENT != 'production') {
            $databaseConfigPath = APPPATH . 'config/' . ENVIRONMENT . '/database.php';
            if (file_exists($databaseConfigPath)) {
                require $databaseConfigPath;
            } else {
                require APPPATH . '/config/database.php';
            }
        } else {
            require APPPATH . '/config/database.php';
        }

        /** @var array $db */

        $connection_options = array(
            'driver'        => 'pdo_mysql',
            'user'          => $db['default']['username'],
            'password'      => $db['default']['password'],
            'host'          => $db['default']['hostname'],
            'dbname'        => $db['default']['database'],
            'charset'       => $db['default']['char_set'],
            'driverOptions' => array(
                'charset'   => $db['default']['char_set'],
            ),
        );

        $proxies_dir = APPPATH . 'models/Proxies';
        $metadata_paths = array(APPPATH . 'models/Entity');

        // Set $dev_mode to TRUE to disable caching while you develop
        $config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode = true, $proxies_dir, null, false);
        $this->em = EntityManager::create($connection_options, $config);
    }

    /**
     * @return static
     */
    public static function &instance()
    {
        if (!static::$instance) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    public static function getEntityManager()
    {
        $instance = static::instance();
        return $instance->em;
    }
}