<?php

namespace App\Http\Requests\Task;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->role == "admin")
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'            =>['required','string','max:50',"min:2"],
            'description'     =>['required','string','max:100'],
            'priority'        =>['required','integer','between:1,10'],
            'due_date'        =>['required','date_format:d-m-Y H:i'],
            'status'          =>['required','boolean'],
            'name'            => ['required','string','exists:users,name'],
        ];
    }
    /**
     * git the user id from its name 
     * 
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
                'max'      => 'The :attribute  must be at max 40.',              
                'date'     => 'The :attribute  must be date type.',
             ];
        
    }

    public function attributes(): array
    {
        return[
            'title'        => 'Task title',
            'description'  => 'Description',
            'priority'     => 'Task Priorpty',
            'due_date'     => 'Due Date',
            'status'      =>'Task Status'

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
