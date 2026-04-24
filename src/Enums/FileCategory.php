<?php

declare(strict_types=1);

namespace Kapil\FileHandler\Enums;

enum FileCategory: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case OTHER = 'other';

    public static function fromMimeType(string $mimeType): self
    {
        $type = explode('/', $mimeType)[0];

        return match ($type) {
            'image' => self::IMAGE,
            'video' => self::VIDEO,
            'audio' => self::AUDIO,
            'application' => self::DOCUMENT,
            default => self::OTHER,
        };
    }
}