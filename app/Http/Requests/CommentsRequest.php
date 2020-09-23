<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CommentsRequest extends FormRequest
{
    public $errorBag;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $atr = [
            'comment_post_ID' => 'integer|required',
            'comment_parent' => 'integer|required',
            'text' => 'string|required',
        ];
        if (!Auth::check()) {
            $atr = Arr::add($atr, 'name', 'required|max:255');
            $atr = Arr::add($atr, 'email', 'email|required|max:255');
            $atr = Arr::add($atr, 'site', 'required|max:255');
        }

        return $atr;
    }

    public function messages() {
        return [
            'email' => 'Поле :attribute должно соответствовать Email адресу',
            'required' => 'Поле :attribute обязательно к заполнению',
        ];
    }


}
