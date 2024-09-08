<?php

namespace App\Http\Requests\Task;


use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
         //get the rout(id) information
        $task = $this->route('task');
        
        return (Auth::id() == $task->assigned_to);
           
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status'          =>['nullable','boolean']
        ];
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
