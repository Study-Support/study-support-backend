<?php

namespace App\Repositories\Base\Eloquents;

use App\Repositories\Base\Contracts\BaseRepository;

/**
 * Class EloquentBaseRepository
 * @package App\Repositories\Base\Eloquents
 */
abstract class EloquentBaseRepository implements BaseRepository
{
    protected $MAX_PER_PAGE = 10;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
        $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {

        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        $result = $this->_model->find($id);

        return $result;
    }

    /**
     * Get one and throw error 404 if not found
     * @param $id
     * @return mixed
     */
    public function findOrFail($id)
    {
        $result = $this->_model->findOrFail($id);

        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {

        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);
            return $result;
        }

        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * create or update user info
     * @param $data
     */
    public function updateOrCreate($match, $data)
    {
        $this->_model->updateOrCreate($match, $data);
    }

    /**
     * get
     *
     * @param  array $conditions
     * @return mixed
     */
    public function where($column = null, $operator = null, $value = null)
    {
        return $this->_model->query()->where($column, $operator, $value);
    }

    /**
     * insert
     * @param $data
     */
    public function insert($attributes)
    {
        $this->_model->insert($attributes);
    }
}
