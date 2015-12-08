<?php
/**
 * Created by PhpStorm.
 * User: kings
 * Date: 5/19/15
 * Time: 9:35 PM
 */

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Jotun\EntityAutoIdTrait;

/**
 * Config
 *
 * @ORM\Table(name="site_config")
 * @ORM\Entity
 */
class SiteConfig
{
    use EntityAutoIdTrait;

    /**
     * @var string
     * @ORM\Column(name="`key`", type="string")
     */
    private $key;

    /**
     * @var string
     * @ORM\Column(name="value", type="string")
     */
    private $value;

    public function getKey()
    {
        return $this->key;
    }

    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    protected static function getObject($key)
    {
        $query = \Doctrine::getEntityManager()->createQueryBuilder()
            ->select('c')
            ->from('Entity\SiteConfig', 'c')
            ->where('c.key = ?1')
            ->setParameter('1', strtolower($key))
            ->setMaxResults(1);

        $object = $query->getQuery()->getOneOrNullResult();

        if (is_null($object)) {
            $object = new SiteConfig();
            $object->setKey($key);
            $object->setValue('');
            \Doctrine::getEntityManager()->persist($object);
            \Doctrine::getEntityManager()->flush();
        }

        return $object;
    }

    public static function getConfig($key, $default = null)
    {
        $object = static::getObject($key);
        if (strlen($object->getValue()) == 0) {
            return $default;
        }

        return $object->getValue();
    }

    public static function setConfig($key, $value)
    {
        $object = static::getObject($key);
        $object->setValue($value);
        \Doctrine::getEntityManager()->flush($object);
    }
}