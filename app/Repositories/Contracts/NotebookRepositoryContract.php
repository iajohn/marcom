<?php

namespace App\Repositories\Contracts;

interface NotebookRepositoryContract
{
    /**
     * @param array $data
     * 
     * @return mixed
     * 
     */
    public function newNote(array $data);
}
