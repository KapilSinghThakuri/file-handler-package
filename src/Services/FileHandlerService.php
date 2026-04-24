<?php
declare(strict_types=1);

namespace Kapil\FileHandler\Services;

use Illuminate\Http\UploadedFile;
use Kapil\FileHandler\Contracts\FileHandlerContract;
use Kapil\FileHandler\DTOs\FileUploadResult;
use Kapil\FileHandler\Support\FileNameSanitizer;

class FileHandlerService implements FileHandlerContract
{
    public function __construct(
        protected FileNameSanitizer $sanitizer
    ) {
    }

    /**
     * Upload a file to the specified directory.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param array{
     *     disk?: string,
     *     visibility?: string,
     *     prefix?: bool
     * } $options {
     *     @var string $disk The filesystem disk to use (default: filesystem.default)
     *     @var string $visibility File visibility (default: private)
     *     @var bool $prefix Whether to add Year/Month prefix (default: true)
     * }
     * @throws \RuntimeException
     * @return FileUploadResult
     */
    public function upload(
        UploadedFile $file,
        string $directory,
        array $options = []
    ): FileUploadResult {
        $disk = $options['disk'] ?? config('filesystems.default');
        $visibility = $options['visibility'] ?? 'private';
        $datePrefix = $options['prefix'] ?? true;

        if ($datePrefix) {
            $directory = rtrim($directory, '/') . '/' . now()->format('Y/m');
        }
        $mimeType = $file->getMimeType();
        $storedName = $this->sanitizer->generateSafe($mimeType);
        $checksum = hash_file('sha256', $file->getRealPath());

        $path = $file->storeAs($directory, $storedName, [
            'disk' => $disk,
            'visibility' => $visibility,
        ]);

        if ($path === false) {
            throw new \RuntimeException("Failed to store file in disk [{$disk}].");
        }

        return new FileUploadResult(
            path: $path,
            disk: $disk,
            originalName: $this->sanitizer->sanitize($file->getClientOriginalName()),
            storedName: $storedName,
            mimeType: $mimeType,
            size: $file->getSize(),
            checksum: $checksum,
            extension: $this->sanitizer->extensionFromMime($mimeType),
        );
    }
}
