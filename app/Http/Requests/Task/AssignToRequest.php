<?php

namespace App\Http\Requests\Task;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignToRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role == "manager";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => ['required','string','exists:users,name'],
        ];
    }
    /**
     * git the user id from its name 
     * @return void
     */
    protected function passedValidation(): void
    {    
        $user = User::where('name', $this->name)->first();
       
            // Merge the due date into the request data 
           $this->merge([
               'user_id'    => $user->id]);
        
    }


    public function messages(): array
    {
        return [
                'required' => 'The :attribute  is required',
                'string'   => 'The :attribute  must be string.',
                'exsits'      => 'The :attribute  must be exsists in users table.',              
        
             ];
        
    }

    public function attributes(): array
    {
        return[
            'name'  => 'User Name',
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([

            'success'   => false,
            'message'   => 'Filter Validation errors',
            'data'      => $validator->errors(),
            'status'    => 400

        ]));
    }

}
