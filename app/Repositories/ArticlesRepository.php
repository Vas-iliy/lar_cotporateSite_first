<?php


namespace App\Repositories;


use App\Article;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $str = Str::random(8);
                $obj = new \stdClass();

                $obj->mini = $str . '_mini.jpg';
                $obj->max = $str . '_max.jpg';
                $obj->path = $str . '.jpg';

                $img = Image::make($image);
                $img->fit(config('settings.image')['width'], config('settings.image')['height'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->path);
                $img->fit(config('settings.articles_img')['max']['width'], config('settings.articles_img')['max']['height'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->max);
                $img->fit(config('settings.articles_img')['mini']['width'], config('settings.articles_img')['mini']['height'])
                    ->save(public_path() . '/' . env('THEME') . '/images/articles/' . $obj->mini);

                $data['img'] = json_encode($obj);
                $this->model->fill($data);
                if ($request->user()->articles()->save($this->model)) {
                    return ['status' => 'Материал успешно добавлен'];
                }
            }
        }

    }

}
