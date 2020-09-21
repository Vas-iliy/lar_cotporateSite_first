<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\ArticlesRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\PortfolioRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class ArticlesController extends SiteController
{

    public function __construct(PortfolioRepository $p_rep, ArticlesRepository $a_rep, CommentsRepository $c_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->c_rep = $c_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.articles';
    }

    /**
     * Display a listing of the resource.
     *
     * @param bool $cat_alias
     * @return Factory|View
     * @throws \Throwable
     */
    public function index($cat_alias = false)
    {
        $articles = $this->getArticles($cat_alias);
        $content = view(env('THEME') . '.articles_content', compact('articles'))->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME') . '.articlesBar', compact(['comments', 'portfolios']))->render();


        return $this->renderOutput();
    }

    protected function getArticles($alias = false) {

        $where = false;

        if ($alias) {
            $id = Category::select('id')->where('alias', $alias)->first()->id;
            $where = ['category_id', $id];
        }

        $articles = $this->a_rep->get('*', false, true, $where);

        if ($articles) {
            //подгружаем информацию по связаным моделям, исключая нагрузку на сервер
            $articles->load('user', 'category', 'comments');
        }

        return $articles;
    }

    protected function getComments($take) {
        $comments = $this->c_rep->get('*', $take);

        if ($comments) {
            //подгружаем информацию по связаным моделям, исключая нагрузку на сервер
            $comments->load('article', 'user');
        }

        return $comments;
    }

    protected function getPortfolios($take) {
        $portfolios = $this->p_rep->get('*', $take);

        return $portfolios;
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
     * @param $alias
     * @return Factory|View
     */
    public function show($alias)
    {
        $article = $this->a_rep->one($alias, ['comments' => true]);
        if ($article) {
            $article->img = json_decode($article->img);
        }
        $content = view(env('THEME') . '.article_content', compact('article'))->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));
        $this->contentRightBar = view(env('THEME') . '.articlesBar', compact(['comments', 'portfolios']))->render();


        return $this->renderOutput();
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
