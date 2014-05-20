<?php
/**
 * @package RonaldCastillo\Base\Repository
 * @copyright Copyright (c) 2013 Ronald Castillo. (http://github.com/ronaldcastillo)
 */
namespace RonaldCastillo\Base\Repository;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AbstractRepository
 *
 * @abstract
 * @author Ronald A. Castillo G. <ronaldcastillo@gmail.com>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $instance;

    public function __construct(Model $instance)
    {
        $this->instance = $instance;
    }
    /**
     * Returns all models
     *
     * @return Model[]
     */
    public function all()
    {
        return $this->instance->all();
    }
    /**
     * Returns a model instance by its ID attribute
     *
     * @param $id
     * @return Model
     */
    public function find($id)
    {
        return $this->instance->find($id);
    }
}
