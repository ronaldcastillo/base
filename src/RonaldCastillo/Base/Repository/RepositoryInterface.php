<?php
/**
 * @package RonaldCastillo\Base\Repository
 * @copyright Copyright (c) 2013 Ronald Castillo. (http://github.com/ronaldcastillo)
 */
namespace RonaldCastillo\Base\Repository;
/**
 * Interface RepositoryInterface
 * @author Ronald A. Castillo G. <ronaldcastillo@gmail.com>
 */
interface RepositoryInterface
{
    /**
     * Returns all models
     *
     * @return mixed
     */
    public function all();
    /**
     * Returns a model instance by its ID attribute
     *
     * @param $id
     * @return mixed
     */
    public function find($id);
}
