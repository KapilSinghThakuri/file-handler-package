<?php
declare(strict_types=1);

use Kapil\FileHandler\Enums\DiskType;

/*
 * You can place your custom package configuration in here.
 */
return [
    'default_disk' => env('FILE_HANDLER_DISK', DiskType::LOCAL),
];