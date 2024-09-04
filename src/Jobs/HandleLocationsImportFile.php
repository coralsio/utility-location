<?php

namespace Corals\Utility\Location\Jobs;

use Corals\Foundation\Traits\ImportTrait;
use Corals\Utility\Location\Http\Requests\LocationRequest;
use Corals\Utility\Location\Models\Location;
use Corals\Utility\Location\Services\LocationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use League\Csv\{Exception as CSVException};

class HandleLocationsImportFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ImportTrait;

    protected $importFilePath;

    /**
     * @var array
     */
    protected $importHeaders;
    protected $user;

    /**
     * HandleBrandsImportFile constructor.
     * @param $importFilePath
     * @param $user
     */
    public function __construct($importFilePath, $user)
    {
        $this->user = $user;
        $this->importFilePath = $importFilePath;
        $this->importHeaders = array_keys(trans('utility-location::import.location-headers'));
    }


    /**
     * @throws CSVException
     */
    public function handle()
    {
        $this->doImport();
    }

    /**
     * @param $record
     * @throws \Exception
     */
    protected function handleImportRecord($record)
    {
        $record = array_map('trim', $record);

        $locationData = $this->getLocationData($record);

        $this->validateRecord($locationData);

        $locationModel = Location::query()->where('name', $locationData['name'])->first();

        $locationRequest = new LocationRequest();

        $locationRequest->replace($locationData);

        $locationService = new LocationService();

        if ($locationModel) {
            $locationService->update($locationRequest, $locationModel);
        } else {
            $locationService->store($locationRequest, Location::class);
        }
    }

    /**
     * @param $record
     * @return array
     * @throws \Exception
     */
    protected function getLocationData($record)
    {
        return array_filter([
            'name' => data_get($record, 'name'),
            'address' => data_get($record, 'address'),
            'lat' => data_get($record, 'lat'),
            'long' => data_get($record, 'long'),
        ]);
    }

    protected function initHandler()
    {
    }

    protected function getValidationRules($data): array
    {
        return [
            'name' => 'required|max:191|unique:utility_locations,name',
            'address' => 'required|max:191',
            'lat' => 'required|max:191',
            'long' => 'required|max:191',
        ];
    }
}
