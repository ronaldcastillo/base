<?php
/**
 * @package RonaldCastillo/Base/Behaviors
 * @copyright Copyright (c) 2013 Ronald Castillo. (http://github.com/ronaldcastillo)
 */
namespace RonaldCastillo\Base\Behaviors;

use Illuminate\Support\MessageBag;

/**
 * Validation trait
 *
 * Adds validation capabilities to a Laravel Eloquent model
 *
 * @author Ronald A. Castillo G. <ronaldcastillo@gmail.com>
 */
trait Validation
{
    /**
     * Merge Rules
     *
     * Merge the rules arrays to form one set of rules
     */
    private function mergeRules()
    {
        $output = [];
        if($this->exists) {
            $merged = array_merge_recursive(static::$rules['saving'], isset(static::$rules['updating']) ? static::$rules['updating'] : [] );
        } else {
            $merged = array_merge_recursive(static::$rules['saving'], isset(static::$rules['creating']) ? static::$rules['creating'] : [] );
        }
        foreach($merged as $field => $rules) {
            if(is_array($rules)) {
                $output[$field] = implode("|", $rules);
            } else {
                $output[$field] = $rules;
            }
        }
        return $output;
    }

    /**
     * Validates the model
     *
     * @access public
     * @return boolean Returns true if validation passed
     *
     * @throws ValidationException
     */
    public function validate()
    {
        $messages = isset(static::$rules['messages']) ? static::$rules['messages'] : [] ;
        $validation = $this->validator->make($this->attributes, $this->mergeRules(), $messages);
        // Check validation rules
        if($validation->fails()) {
            // If the validation fails, we save the
            // messages to the $this->errors properties
            // $this->errors = $validation->messages();
            // And return false, to stop the model from saving/updating
            throw new ValidationException($validation->messages(), implode(', ', $validation->messages()->all()));
        }
        // If it passes we return true
        // so the model can continue saving/updating
        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}

class ValidationException extends \RuntimeException
{

    /**
     * @var MessageBag
     */
    protected $validationMessages;

    public function __construct(MessageBag $validationMessages, $message, $code = 0, $previousException = null)
    {
        parent::__construct($message, $code, $previousException);
    }

    /**
     * @return MessageBag
     */
    public function getValidationMessages()
    {
        return $this->validationMessages;
    }
}