<?php

namespace App\Repositories;

use App\Models\Notebook;
use App\Repositories\Contracts\NotebookRepositoryContract;

class NotebookRepository implements NotebookRepositoryContract
{
    /**
     * Create new Notebook
     * 
     * @param  array  $data
     * @return mixed
     */
    public function newNote(array $data)
    {
        try {
            $newNote = new Notebook();
            $newNote->fill($data);
            $newNote->save();

            return $newNote;
        } catch (\Throwable $error) {
            return $error->getMessage();
        }
    }
   
}
