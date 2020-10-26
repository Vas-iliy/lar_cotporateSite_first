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
        }
        if ($this->one($data['alias'], false)) {
            $request->merge(['alias' => $data['alias']]);
            $request->flash();

            return ['error' => 'Данный псевдоним уже используется'];
        }

        $data['img'] = $this->jobImage($request);

        $this->model->fill($data);
        if ($request->user()->articles()->save($this->model)) {
            return ['status' => 'Материал успешно добавлен'];
        }

    }

    public function updateArticle($request, $article) {
        if (Gate::denies('edit', $this->model)) {
            abort(403);
        }
        $data = $request->except('_token', 'image', '_method');

        if (empty($data)) {
            return ['error' => 'Нет данных'];
        }
        if (empty($data['alias'])) {
            $data['alias'] = $this->transliterate($data['title']);
        }

        $result = $this->one($data['alias'], false);
        if ($result) {
            if ($result->id != $article->id) {
                $request->merge(['alias' => $data['alias']]);
                $request->flash();

                return ['error' => 'Данный псевдоним уже используется'];
            }
        }

        $data['img'] = $this->jobImage($request);

        $article->fill($data);

        if ($article->update()) {
            return ['status' => 'Материал успешно обновлен'];
        }

    }

    public function deleteArticle($article) {
        if (Gate::denies('destroy', $article)) {
            abort(403);
        }
        $article->comments()->delete();

        if ($article->delete()) {
            return ['status' => 'Материал успешно удален'];
        }
    }
}
