<?php

namespace App\Repositories\Base\Contracts;

interface BaseRepository
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * Get one and throw error 404 if not found
     * @param $id
     * @return mixed
     */
    public function findOrFail($id);

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);
    
	/**
     * create or update user info
     * @param $data
     */
	public function updateOrCreate($match, $data);

    /**
     * First where
     * @param $param
     * @return mixed
     */
    public function where($column = null, $operator = null, $value = null);

    /**
     * Insert
     * @param array $attributes
     * @return mixed
     */
    public function insert(array $attributes);
}