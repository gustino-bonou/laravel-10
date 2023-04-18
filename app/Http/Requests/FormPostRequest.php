<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormPostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required'],
            'title' => ['required', 'min:8'],
            //ce champs est requis, 8caracts minim, doit etre sous la forme mot-mot1-mots3... et est unique dans le table posts, mais cette unicité est ignorée pour le post en cours de modification recuperé de par la route
            'slug' => ['required', 'min:8', 'regex:/^[0-9a-z\-]+$/', Rule::unique('posts')->ignore($this->route()->parameter('post'))] ,
            //ce champ est requis, et doit exister dans le table catégories correspondant à la colonne id
            'category_id' => ['required', 'exists:categories,id'],
            //ce champ est requis, c'est un tableau et doit exister dans le table tags correspondant à la colonne id
            'tags' => ['array', 'exists:tags,id', 'required'],
            //validation de l'image, on pourrait limiter le type, taille, dimensions...
            'image' => ['image', 'max:2000']
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'slug' => $this->input('slug') ? : Str::slug($this->input('title'))
        ]);
    }
}
