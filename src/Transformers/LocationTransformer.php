<?php

namespace Corals\Utility\Location\Transformers;

use Corals\Foundation\Transformers\BaseTransformer;
use Corals\Utility\Location\Models\Location;

class LocationTransformer extends BaseTransformer
{
    public function __construct($extras = [])
    {
        $this->resource_url = config('utility-location.models.location.resource_url');

        parent::__construct($extras);
    }

    /**
     * @param Location $location
     * @return array
     * @throws \Throwable
     */
    public function transform(Location $location)
    {
        $transformedArray = [
            'id' => $location->id,
            'checkbox' => $this->generateCheckboxElement($location),
            'name' => $location->name,
            'address' => $location->address,
            'lat' => $location->lat,
            'long' => $location->long,
            'zip' => $location->zip,
            'city' => $location->city,
            'state' => $location->state,
            'country' => $location->country,
            'status' => formatStatusAsLabels($location->status),
            'created_at' => format_date($location->created_at),
            'updated_at' => format_date($location->updated_at),
            'action' => $this->actions($location),
        ];

        return parent::transformResponse($transformedArray);
    }
}
