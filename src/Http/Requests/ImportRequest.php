<?php

namespace Corals\Utility\Location\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Illuminate\Support\Str;

class ImportRequest extends BaseRequest
{
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
        $rules = parent::rules();

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'file' => 'required|mimes:csv,txt|max:' . maxUploadFileSize(),
            ]);
            $target = Str::singular(request()->segments()[1]);

        }

        return $rules;
    }
}
