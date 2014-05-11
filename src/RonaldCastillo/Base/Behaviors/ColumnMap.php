<?php
/**
 * @package RonaldCastillo/Base/Behaviors
 * @copyright Copyright (c) 2013 Ronald Castillo. (http://github.com/ronaldcastillo)
 */
namespace RonaldCastillo\Base\Behaviors;
/**
 * ColumnMap trait
 * 
 * Allows to map column names to their underlying name, useful for setting up column aliases,
 * specially if you're not into snake casing.
 *
 * @author Ronald A. Castillo G. <ronaldcastillo@gmail.com>
 */
trait ColumnMap
{
    /**
     * Allows mapping column names
     *
     * @var array
     * @access protected
     * @static
     */
    public static $columnMap = [];

    /**
     * Set a given attribute on the model.
     * Allow column mapping.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute($this->getColumnMapKey($key), $value);
    }

    /**
     * Get an attribute from the model.
     * Allow column mapping.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        return parent::getAttribute($this->getColumnMapKey($key));
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param $key
     * @return bool
     */
    public function __isset($key)
    {
        return parent::__isset($this->getColumnMapKey($key));
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        return parent::__unset($this->getColumnMapKey($key));
    }

    protected function getColumnMapKey($key)
    {
        if(isset(static::$columnMap[$key])) {
            $key = static::$columnMap[$key];
        }
        return $key;
    }

}
