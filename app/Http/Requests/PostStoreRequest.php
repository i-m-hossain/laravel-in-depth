<?php

namespace App\Http\Requests;
use App\Rules\IntegerArrayRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "title"=>"string | required",
            "body"=> "string| required",
            'user_ids'=>[
                'array',
                'required',
                new IntegerArrayRule() //custom error validation
                // function($attribute, $value, $fail){
                //     $isInteger = collect($value)->every(fn($item)=>is_int($item));
                //     if(!$isInteger){
                //         $fail($attribute.' can only be integer');
                //     }
                // }
            ]
        ];
    }
    public function messages():array
    {
        return [
            'title.required'=>'title can not be empty!',
            'title.string'=>'hey, title should be string!',
            'body.required'=>'body can not be empty bro!',
            'body.string'=>'hello, body should be string',
            'user_ids.required'=> 'user ids can not be empty!',
            'user_ids.array'=>'user_ids should be an array!'
        ];
    }
}
