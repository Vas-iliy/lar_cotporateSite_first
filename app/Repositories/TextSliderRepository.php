<?php


namespace App\Repositories;


use App\TextSlider;

class TextSliderRepository extends Repository
{
    public function __construct(TextSlider $textSlider)
    {
        $this->model = $textSlider;
    }

}
