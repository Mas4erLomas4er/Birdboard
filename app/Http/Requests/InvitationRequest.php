<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class InvitationRequest extends FormRequest
{
    protected $errorBag = 'invitations';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return Gate::allows('invite', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ()
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }

    public function messages ()
    {
        return [
            'email.exists' => 'The user you are inviting must have a Birdboard account',
        ];
    }
}