<?php
class JotunUtils
{
    protected static $ci;
    private static function getCI()
    {
        if (!static::$ci) {
            static::$ci = & get_instance();
        }

        return static::$ci;
    }

    /**
     * Making hashed password for secured storage user info
     *
     * @param string $password
     * @return string
     */
    public static function passwordHash($password)
    {
        $key = static::getCI()->config->config['encryption_key'];
        return md5(sha1( substr($key, 0,5) . $password . substr($key, -5) ));
    }

    public static function getStartOfMonth($time)
    {
        if (!$time instanceof \DateTime) {
            $time = \DateTime::createFromFormat('m/Y', $time);
        }
        $start = \DateTime::createFromFormat('d-m-Y H:i:s', $time->format('01-m-Y 00:00:00'));

        return $start;
    }

    public static function getEndOfMonth($time)
    {
        if (!$time instanceof \DateTime) {
            $time = \DateTime::createFromFormat('m/Y', $time);
        }
        $end = \DateTime::createFromFormat('d-m-Y H:i:s', $time->format('t-m-Y 23:59:59'));

        return $end;
    }

    public static function currencyFormat($value)
    {
        return number_format(round($value * 1000));
    }
}