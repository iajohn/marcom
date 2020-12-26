<?php

namespace App\Http\Controllers\Notebooks;

use App\Models\Notebook;
use App\Helpers\ResponseHelper;
use App\Services\NotebookService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\NotebookRequest as Request;

class NotebookController extends Controller
{
    /**
     * @var ResponseHelper
     * 
     */
    protected $response;

    /**
     * @var NotebookService
     * 
     */
    protected $notebookService;

    /**
     * @var NotebookController constructor
     * 
     * @param NotebookService $notebookService
     * @param ResponseHelper $response
     * @return void
     */
    public function __construct(
        NotebookService $notebookService,
        ResponseHelper $response
    )
    {
        $this->notebookService = $notebookService;
        $this->response = $response;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $notebook = $this->notebookService->newNote($request->all());

        return $this->response->successResponse(
            true, 
            "New notebook created successfully",
            $notebook,
            401
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function show(Notebook $notebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function edit(Notebook $notebook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notebook $notebook)
    {
        //
    }

    /**
     * Notebook Image Upload
     *
     * @param Request $request
     * @return string $url
     */
    public function upload(Request $request)
    {
        $v = validator($request->all(), ['upload' => 'required']);

        if($v->fails()) {
            return response()->json([
                'error' => ['message' => $v->errors()->first()]
            ]);
        }

        $url = $request->upload->store('uploads', 'public');

        $url = asset("storage/$url");

        return response()->json(compact("url"), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notebook  $notebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notebook $notebook)
    {
        //
    }
}
