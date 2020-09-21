<?php


namespace App\Repositories;


use App\Article;

class ArticlesRepository extends Repository
{
    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function one($alias, $atr = []) {
        $article = parent::one($alias, $atr );
        if ($article && !empty($atr)) {
            $article->load('comments');
            $article->comments->load('user');
        }

        return $article;
    }

}
