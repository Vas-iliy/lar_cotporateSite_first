<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ArticlesRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ArticlesController extends AdminController
{
    public function __construct(ArticlesRepository $a_rep)
    {
        parent::__construct();

        $this->a_rep = $a_rep;

        $this->template = env('THEME') . '.admin.articles';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (Gate::denies('view_admin_articles')) {
            abort(403);
        }

        $articles = $this->getArticles();
        $this->content = view(env('THEME') . '.admin.articles_content', compact('articles'))->render();

        $this->title = 'Менеджер статей';
        return $this->renderOutput();
    }

    private function getArticles() {
        return $this->a_rep->get();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
