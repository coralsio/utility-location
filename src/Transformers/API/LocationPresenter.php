<?php

namespace Corals\Modules\Utility\Location\Transformers\API;

use Corals\Foundation\Transformers\FractalPresenter;

class LocationPresenter extends FractalPresenter
{
    /**
     * @return LocationTransformer
     */
    public function getTransformer()
    {
        return new LocationTransformer();
    }
}
