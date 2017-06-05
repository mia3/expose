<?php
/**
 * Created by PhpStorm.
 * User: mneuhaus
 * Date: 30.10.16
 * Time: 02:23
 */

namespace Mia3\Expose\Action\Index;


class Item
{

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var array
     */
    protected $properties = array();

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        if (empty($this->properties)) {
            return array('' => $this->value);
        }

        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }
}