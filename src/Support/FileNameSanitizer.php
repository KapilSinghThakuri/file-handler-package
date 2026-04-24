<?php

namespace Kapil\FileHandler\Support;

use Illuminate\Support\Str;

class FileNameSanitizer
{
    /**
     * Dangerous extensions that should never be stored as-is.
     */
    private const BLOCKED_EXTENSIONS = [
        'php',
        'php3',
        'php4',
        'phtml',
        'phar',
        'exe',
        'sh',
        'bat',
        'cmd',
        'com',
        'py',
        'rb',
        'pl',
        'cgi',
        'js',
        'vbs',
        'wsf',
        'htaccess',
        'htpasswd',
    ];

    /**
     * Map detected MIME types to safe extensions.
     * This is used instead of trusting the client-supplied extension.
     */
    private const MIME_TO_EXTENSION = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'application/pdf' => 'pdf',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
        'application/vnd.ms-excel' => 'xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
        'text/plain' => 'txt',
        'application/zip' => 'zip',
        'video/mp4' => 'mp4',
    ];

    /**
     * Generate a completely new, safe filename using a UUID.
     * The extension is derived from the server-detected MIME type —
     * never from the client-supplied filename.
     */
    public function generateSafe(string $mimeType): string
    {
        $extension = self::MIME_TO_EXTENSION[$mimeType] ?? 'bin';
        return (string) Str::uuid() . '.' . $extension;
    }

    /**
     * Sanitize a user-supplied filename when you need to preserve
     * a human-readable name (e.g. for the original_name column).
     */
    public function sanitize(string $filename): string
    {
        // Strip directory traversal components
        $filename = basename($filename);

        // Remove null bytes (common in injection attempts)
        $filename = str_replace("\0", '', $filename);

        // Allow only safe characters: letters, numbers, dash, underscore, dot
        $filename = preg_replace('/[^\w\-.]/', '_', $filename);

        // Prevent hidden files ("." prefix)
        $filename = ltrim($filename, '.');

        // Prevent double extensions like "evil.php.jpg"
        $filename = $this->stripDoubleExtensions($filename);

        // Truncate to a safe length
        return Str::limit($filename, 120, '');
    }

    public function isBlockedExtension(string $extension): bool
    {
        return in_array(strtolower($extension), self::BLOCKED_EXTENSIONS, true);
    }

    public function extensionFromMime(string $mimeType): string
    {
        return self::MIME_TO_EXTENSION[$mimeType] ?? 'bin';
    }

    private function stripDoubleExtensions(string $filename): string
    {
        // Split on dots, filter out any segment that is a blocked extension
        $parts = explode('.', $filename);
        $baseParts = array_slice($parts, 0, -1);
        $extension = array_pop($parts);

        $safeParts = array_filter($baseParts, function (string $part): bool {
            return !$this->isBlockedExtension($part);
        });

        $safeParts[] = $extension;
        return implode('.', $safeParts);
    }
}