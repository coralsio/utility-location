<?php

return [
    'labels' => [
        'import' => '<i class="fa fa-th fa-th"></i> Import',
        'download_sample' => '<i class="fa fa-download fa-th"></i> Download Import Sample',
        'column' => 'Column',
        'description' => 'Description',
        'column_description' => 'Import columns description',
        'file' => 'Import File (csv)',
        'upload_file' => '<i class="fa fa-upload fa-th"></i> Upload',
    ],
    'messages' => [
        'file_uploaded' => 'File has been uploaded successfully and a job dispatched to handle the import process.'
    ],
    'exceptions' => [
        'invalid_headers' => 'Invalid import file columns. Please check the sample import file.',
        'path_not_exist' => 'path not exist.',
    ],
    'location-headers' => [
        'name' => 'location name',
        'slug' => 'location slug',
        'status' => 'location status',
        'address' => 'location address',
        'lat' => 'location latitude',
        'long' => 'location longitude',
        'zip' => 'location zip',
        'city' => 'location city',
        'state' => 'location state',
        'country' => 'location country',
        'module'=>'module',
        'type' => 'location type',
        'parent_id' => 'parent location',
        'description' => 'location description',
    ],
];
