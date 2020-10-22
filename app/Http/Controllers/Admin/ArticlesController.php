<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Repositories\ArticlesRepository;
use App\Repositories\CategoriesRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ArticlesController extends AdminController
{
    public function __construct(ArticlesRepository $a_rep, CategoriesRepository $c_rep)
    {
        parent::__construct();

        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if (Gate::denies('save', new Article())) {
            abort(403);
        }

        $this->title = 'Добавить новы материал';

        $categories = $this->getCategories();
        $this->content = view(env('THEME') . '.admin.articles_create_content', compact('categories'))->render();

        return $this->renderOutput();
    }

    private function getCategories() {
        return $this->c_rep->get();
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
