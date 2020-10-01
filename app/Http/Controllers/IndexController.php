<?php

namespace App\Http\Controllers;

use App\Repositories\ArticlesRepository;
use App\Repositories\MenusRepository;
use App\Repositories\PortfolioRepository;
use App\Repositories\SlidersRepository;
use App\Repositories\TextSliderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class IndexController extends SiteController
{

    public function __construct(SlidersRepository $s_rep, PortfolioRepository $p_rep, ArticlesRepository $a_rep, TextSliderRepository $text_s_rep)
    {
        parent::__construct(new \App\Repositories\MenusRepository(new \App\Menu));

        $this->s_rep = $s_rep;
        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;
        $this->text_s_rep = $text_s_rep;

        $this->bar = 'right';
        $this->template = env('THEME') . '.index';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index()
    {
        $portfolios = $this->getPortfolio();
        $content = view(env('THEME') . '.content', compact('portfolios'))->render();
        $this->vars = Arr::add($this->vars, 'content', $content);

        $sliderItems = $this->getSliders();
        $sliders = view(env('THEME') . '.slider')->with('sliders', $sliderItems)->render();
        $this->vars = Arr::add($this->vars,'sliders', $sliders);

        $contentSlider = $this->getTextSlider();
        $text_slider = view(env('THEME') . '.text_slider', compact('contentSlider'))->render();

        $articles = $this->getArticles();
        $this->contentRightBar = view(env('THEME') . '.indexBar', compact(['articles', 'text_slider']))->render();

        $this->keywords = 'Home Page';
        $this->meta_desc = 'Home Page';
        $this->title = 'Home Page';

        return $this->renderOutput();
    }

    public function getSliders()
    {
        $sliders = $this->s_rep->get();
        if ($sliders->isEmpty()) {
            return false;
        }
        $sliders->transform(function ($item, $key) {
            $item->img = Config::get('settings.slider_path') . '/' . $item->img;

            return $item;
        });

        return $sliders;
    }

    protected function getPortfolio()
    {
        $portfolio = $this->p_rep->get('*', Config::get('settings.home_port_count'));

        return $portfolio;
    }

    protected function getArticles()
    {
        $articles = $this->a_rep->get(['title', 'created_at', 'img', 'alias'], Config::get('settings.home_articles_count'));

        return $articles;
    }

    public function getTextSlider()
    {
        $textSlider = $this->text_s_rep->get();
        if ($textSlider->isEmpty()) {
            return false;
        }

        return $textSlider;
    }
}
