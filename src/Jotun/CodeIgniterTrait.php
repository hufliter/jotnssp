<?php namespace Jotun;
trait CodeIgniterTrait
{
    /**
     * @return \AppController
     */
    protected function getCI()
    {
        return get_instance();
    }
}
