<?php

namespace Corals\Modules\Utility\Location\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Modules\Utility\Location\DataTables\LocationsDataTable;
use Corals\Modules\Utility\Location\Http\Requests\LocationRequest;
use Corals\Modules\Utility\Location\Models\Location;
use Corals\Modules\Utility\Location\Services\LocationService;
use Corals\Modules\Utility\Location\Transformers\API\LocationPresenter;

class LocationsController extends APIBaseController
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
        $this->locationService->setPresenter(new LocationPresenter());

        parent::__construct();
    }

    /**
     * @param LocationRequest $request
     * @param LocationsDataTable $dataTable
     * @return mixed
     */
    public function index(LocationRequest $request, LocationsDataTable $dataTable)
    {
        $locations = $dataTable->query(new Location());

        return $this->locationService->index($locations, $dataTable);
    }

    /**
     * @param LocationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationRequest $request)
    {
        try {
            $location = $this->locationService->store($request, Location::class);
            return apiResponse($this->locationService->getModelDetails(), trans('Corals::messages.success.created', ['item' => $location->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LocationRequest $request, Location $location)
    {
        try {
            return apiResponse($this->locationService->getModelDetails($location));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LocationRequest $request, Location $location)
    {
        try {
            $this->locationService->update($request, $location);

            return apiResponse($this->locationService->getModelDetails(), trans('Corals::messages.success.updated', ['item' => $location->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param LocationRequest $request
     * @param Location $location
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LocationRequest $request, Location $location)
    {
        try {
            $this->locationService->destroy($request, $location);

            return apiResponse([], trans('Corals::messages.success.deleted', ['item' => $location->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
