<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();

        return [
            "name" => 'required|alpha',
            "email" => 'required|email|unique:users,id,'.$user->id,
            "password" => 'min:6|regex:"^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$"|confirmed|sometimes|nullable',
            //"role" => 'required|in:'.implode(',', config('auth.user_roles')),
        ];
    }
}
