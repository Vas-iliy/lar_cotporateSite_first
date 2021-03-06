<?php

namespace App\Http\Controllers;

use App\Repositories\PortfolioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PortfolioController extends SiteController
{

    public function __construct(PortfolioRepository $p_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->p_rep = $p_rep;

        $this->template = env('THEME') . '.portfolios';

        $this->descr = '<h3>Welcome to my portfolio page</h3>
                    <h4>... i hope you enjoy my works</h4>';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index()
    {
        $this->title = 'Портволио';
        $this->keywords = 'Портволио';
        $this->meta_desc = 'Портволио';

        $portfolios = $this->getPortfolios();

        $content = view(env('THEME') . '.content_portfolios', compact('portfolios'))->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        return $this->renderOutput();
    }

    protected function getPortfolios($take = false, $paginate = true) {
        $portfolios = $this->p_rep->get('*', $take, $paginate);
        if ($portfolios) {
            $portfolios->load('filter');
        }

        return $portfolios;
    }

    /**
     * Display the specified resource.
     *
     * @param $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function show($alias)
    {
        $portfolio = $this->p_rep->one($alias);

        $portfolios = $this->getPortfolios(config('settings.other_portfolios'), false);

        $this->title = $portfolio->title;
        $this->keywords = $portfolio->keywords;
        $this->meta_desc = $portfolio->meta_desc;


        $content = view(env('THEME') . '.portfolio_content', compact(['portfolio', 'portfolios']))->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        return $this->renderOutput();
    }
}
