<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $p_rep;
    protected $a_rep;
    protected $user;
    protected $template;
    protected $content = false;
    protected $title;
    protected $vars = [];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user= Auth::user();

            return $next($request);
        });
    }

    public function renderOutput() {
        $this->vars = Arr::add($this->vars, 'title', $this->title);

        $menu = $this->getMenu();
        $navigation = view(env('THEME') . '.admin.navigation', compact('menu'))->render();
        $this->vars = Arr::add($this->vars, 'navigation', $navigation);

        if ($this->content) {
            $this->vars = Arr::add($this->vars, 'content', $this->content);
        }

        $footer = view(env('THEME') . '.admin.footer')->render();
        $this->vars = Arr::add($this->vars, 'footer', $footer);

        return view($this->template)->with($this->vars);
    }

    public function getMenu() {
        return \Menu::make('adminMenu', function ($menu) {
            $menu->add('Статьи', ['route' => 'article.index']);
            $menu->add('Портволио', ['route' => 'article.index']);
            $menu->add('Меню', ['route' => 'article.index']);
            $menu->add('Пользователи', ['route' => 'article.index']);
            $menu->add('Привелегии', ['route' => 'article.index']);
        });
    }
}
