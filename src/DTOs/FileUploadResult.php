<?php

namespace Kapil\FileHandler\DTOs;

use Illuminate\Contracts\Support\Arrayable;

final class FileUploadResult implements Arrayable
{
    public function __construct(
        public readonly string $path,
        public readonly string $disk,
        public readonly string $originalName,
        public readonly string $storedName,
        public readonly string $mimeType,
        public readonly int $size,
        public readonly string $checksum,
        public readonly string $extension,
    ) {
    }

    /**
     * Summary of toArray
     * @return array{checksum: string, disk: string, extension: string, mime_type: string, original_name: string, path: string, size: int, stored_name: string}
     */
    public function toArray(): array
    {
        return [
            'path' => $this->path,
            'disk' => $this->disk,
            'original_name' => $this->originalName,
            'stored_name' => $this->storedName,
            'mime_type' => $this->mimeType,
            'size' => $this->size,
            'checksum' => $this->checksum,
            'extension' => $this->extension,
        ];
    }

    /**
     * Summary of fromArray
     * @param array $data
     * @return FileUploadResult
     */
    public static function fromArray(array $data): self
    {
        return new self(
            path: $data['path'],
            disk: $data['disk'],
            originalName: $data['original_name'],
            storedName: $data['stored_name'],
            mimeType: $data['mime_type'],
            size: $data['size'],
            checksum: $data['checksum'],
            extension: $data['extension'],
        );
    }
}