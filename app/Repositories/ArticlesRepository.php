<?php


namespace App\Repositories;


use App\Article;
use Illuminate\Support\Facades\Gate;

class ArticlesRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function one($alias, $atr = []) {
        $article = parent::one($alias, $atr );

        if ($article) {
            $article->img = json_decode($article->img);
        }

        if ($article && !empty($atr)) {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;
    }

    public function addArticle($request) {
        if (Gate::denies('save', $this->model)) {
            abort(403);
        }
        $data = $request->except('_token', 'image');

        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }

        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
            dd($data);
        }

    }

}
