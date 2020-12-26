<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Contracts\NotebookRepositoryContract;

class NotebookService
{
    /**
     * @var NotebookRepositoryContract
     * 
     */
    protected $notebookRepositoryContract;

    /**
     * @var NotebookService constructor
     * 
     * @param NotebookRepositoryContract $notebookRepositoryContrac
     * 
     */
    public function __construct(NotebookRepositoryContract $notebookRepositoryContract)
    {
        $this->notebookRepositoryContract = $notebookRepositoryContract;
    }

   public function newNote(array $data)
   {
       $userId = Auth::user()->id;

       $noteData = [
            'user_id'     => $userId,
            'title'       => $data['title'],
            'slug'        => $data['slug'],
            'cover_image' => $data['cover_image'],
            'discription' => $data['content'],
            'content'     => $data['content'],
            'is_private'  => $data['is_private'],
        ];

        return $this->notebookRepositoryContract->newNote($noteData);
   }
}
