<?php


namespace App\Repositories;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

abstract class Repository
{
    protected $model = false;

    public function get($select = '*', $take = false, $pagination = false, $where = false) {
        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        if ($where) {
            $builder->where($where[0], $where[1]);
        }

        if ($pagination) {
            return $this->check($builder->paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    protected function check($result) {
        if ($result->isEmpty()) {
            return false;
        }
        $result->transform(function ($item, $key) {
            if (is_string($item->img) && is_object(json_decode($item->img)) && (json_last_error() == JSON_ERROR_NONE)) {
                $item->img = json_decode($item->img);
            }

            return $item;
        });

        return $result;
    }

    public function one($alias, $atr = []) {
        $result = $this->model->where('alias', $alias)->first();

        return $result;
    }

    public function transliterate($string) {
        $str = mb_strtolower($string);
        $later_array = [
            'а' => 'a',   'б' => 'b',   'в' => 'v',

            'г' => 'g',   'д' => 'd',   'е' => 'e',

            'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',

            'и' => 'i',   'й' => 'j',   'к' => 'k',

            'л' => 'l',   'м' => 'm',   'н' => 'n',

            'о' => 'o',   'п' => 'p',   'р' => 'r',

            'с' => 's',   'т' => 't',   'у' => 'u',

            'ф' => 'f',   'х' => 'x',   'ц' => 'c',

            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',

            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'\'',

            'э' => 'e\'',   'ю' => 'yu',  'я' => 'ya',
        ];
        foreach ($later_array as $kyr => $later) {
            $str = str_replace($kyr, $later, $str);
        }
        $str = preg_replace('/(\s|[^A-Za-z0-9\-])+/', '-', $str);
        $str = trim($str, '-');

        return $str;
    }

    public function jobImage($request) {
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

                return json_encode($obj);
            }
            return false;
        }
        return false;
    }
}
