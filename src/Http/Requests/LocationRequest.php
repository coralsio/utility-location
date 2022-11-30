<?php

namespace Corals\Modules\Utility\Location\Http\Requests;

use Corals\Foundation\Http\Requests\BaseRequest;
use Corals\Modules\Utility\Location\Models\Location;

class LocationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->setModel(Location::class);

        return $this->isAuthorized();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setModel(Location::class);
        $rules = parent::rules();

        if ($this->isUpdate() || $this->isStore()) {
            $rules = array_merge($rules, [
                'status' => 'required',
                'address' => 'required|max:191',
                'lat' => 'required|max:191',
                'long' => 'required|max:191',
            ]);
        }

        if ($this->isStore()) {
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:utility_locations,name',
            ]);
        }

        if ($this->isUpdate()) {
            $location = $this->route('location');
            $rules = array_merge($rules, [
                'name' => 'required|max:191|unique:utility_locations,name,' . $location->id,
            ]);
        }

        return $rules;
    }
}
