<?php
declare(strict_types=1);
namespace Kapil\FileHandler\Enums;

enum DiskType: string
{
    case LOCAL = 'local';
    case S3 = 's3';
}