<?php namespace RonaldCastillo\Base\Behaviors;

use Illuminate\Support\Str;

trait Purge
{
    /**
     * Purges confirmation fields from the attributes.
     *
     * @return void
     */
    public function purge()
    {
        foreach($this->attributes as $k => $attr) {
            // If the attribute ends in "_confirmation"
            if(Str::endsWith($k, '_confirmation')) {
                // We unset the value
                unset($this->attributes[$k]);
            }
        }
    }
}