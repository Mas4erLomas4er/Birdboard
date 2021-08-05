<?php

namespace App\Http\Requests\Projects;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

/**
 * @property Project project
 */
class UpdateProjectRequest extends FormRequest
{
    protected $errorBag = 'projects';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return Gate::allows('update', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ()
    {
        return [
            'title' => ['required', 'max:50'],
            'description' => ['required', 'max:100'],
            'notes' => ['max:2000'],
        ];
    }
}
