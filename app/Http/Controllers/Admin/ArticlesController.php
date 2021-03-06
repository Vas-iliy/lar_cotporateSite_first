<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Http\Requests\ArticleRequest;
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function store(ArticleRequest $request)
    {
        $result = $this->a_rep->addArticle($request);
        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        else {
            return redirect('/admin')->with($result);
        }
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
     * @param Article $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        if (Gate::denies('edit', new Article())) {
            abort(403);
        }

        $article->img = json_decode($article->img);
        $categories = $this->getCategories();
        $this->title = 'Редактирование материала -' . $article->title;
        $this->content = view(env('THEME') . '.admin.articles_create_content', compact(['categories', 'article']))->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest $request
     * @param Article $article
     * @return void
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $result = $this->a_rep->updateArticle($request, $article);
        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        else {
            return redirect('/admin')->with($result);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return void
     */
    public function destroy(Article $article)
    {
        $result = $this->a_rep->deleteArticle($article);
        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        else {
            return redirect('/admin')->with($result);
        }
    }
}
