<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if($this->route('user') == Auth::user()->id)
		{
			return false;
		}
		return true;
    }

	public function forbiddenResponse()
	{
		return redirect()->back()->withErrors([
			'error' => 'You are not able to delete yourself'
		]);
	}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
