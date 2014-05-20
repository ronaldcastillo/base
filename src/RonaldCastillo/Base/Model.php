<?php
/**
 * @package RonaldCastillo/Base
 * @copyright Copyright (c) 2013 Ronald Castillo. (http://github.com/ronaldcastillo)
 */
namespace RonaldCastillo\Base;

use Illuminate\Events\Dispatcher;
use Illuminate\Validation\Validator;
use Illuminate\Database\Eloquent\Model as Eloquent;

use RonaldCastillo\Base\Behaviors\ColumnMap;
use RonaldCastillo\Base\Behaviors\Validation;

/**
 * Class Model
 *
 * Base Application Model.
 *
 * @abstract
 * @extends \Illuminate\Database\Eloquent\Model
 * @author Ronald A. Castillo G. <ronaldcastillo@gmail.com>
 */
abstract class Model extends Eloquent
{
    use ColumnMap;
    use Validation;
    use Purge;
    /**
     * Validation errors
     *
     * @var \Illuminate\Support\MessageBag
     * @access public
     */
    protected $errors;
    /**
     * Soft deletes are applied by default
     *
     * @var bool
     */
    protected $softDelete = true;
    /**
     * Whether to use validation.
     * Set to "false" to force a model save.
     *
     * @var bool
     * @access public
     */
    public static $validate = true;
    /**
     * Validation rules
     *
     * @var array
     * @access protected
     * @static
     */
    public static $rules = [
        'saving' => [],
        'creating' => [],
        'updating' => [],
        'messages' => []
    ];
    /**
     * Validator instance
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;
    /**
     * Event dispatcher interface
     *
     * @var \Illuminate\Events\Dispatcher
     */
    protected $eventDispatcher;

    public function __construct(array $attributes = [], Validator $validator = null, Dispatcher $eventDispatcher = null)
    {
        parent::__construct($attributes);

        $this->validator = $validator ?: \App::make('validator');
        $this->eventDispatcher = $eventDispatcher ?: \App::make('events');
    }
    /**
     * Eloquent boot method.
     * Sets the necessary events for validation.
     * Adds default columns to static::$columnMap
     *
     * @return void
     */
    public static function boot()
    {

        parent::boot();
        // Validation is enabled for the model
        if(static::$validate) {
            // We attach a hook to the saving event
            static::saving(function(Model $model)
            {
                // Return the validation result
                $model->purge();
                return $model->validate();
            });
        }

        static::$columnMap = array_merge(static::$columnMap, [
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
            'deletedAt' => 'deleted_at'
        ]);
    }
}
