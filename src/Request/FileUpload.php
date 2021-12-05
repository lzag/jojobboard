<?php

namespace App\Request;

use App\Request\FileUploadException;
use finfo;
use Exception;

class FileUpload
{

    /**
     * @var array<string> $allowed;
     */
    private array $allowed;
    private string $name;
    private string $uploadPath;
    private string $extension;
    private string $filename;

    private const MIME_TYPES = [
        'image/bmp' => '.bmp',
        'image/jpeg' => '.jpg',
        'image/gif' => '.gif',
        'image/png' => '.png',
    ];

    /**
     * @param array<string> $allowed;
     */
    public function __construct(string $name, string $uploadPath, array $allowed = null)
    {
        if (!isset($_FILES[$name])) {
            throw new FileUploadException('File not uploaded');
        }
        $this->name = $name;

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0770, true);
        }
        $this->uploadPath = $uploadPath;
        $this->allowed = $allowed ?? self::MIME_TYPES;
    }

    public function validateType(): self
    {
        $finfo = new finfo();
        $mime = $finfo->file($_FILES[$this->name]['tmp_name'], FILEINFO_MIME_TYPE);

        if ($mime === false) {
            throw new FileUploadException('Error analysing file');
        }

        if (!key_exists($mime, $this->allowed)) {
            throw new FileUploadException('File type not allowed');
        }
        $this->extension = $this->allowed[$mime];

        return $this;
    }

    public function isImage(): bool
    {
        if (getimagesize($_FILES[$this->name]['tmp_name']) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function isEmpty(): bool
    {
        return ($_FILES[$this->name]['error'] === UPLOAD_ERR_NO_FILE);
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setFilename(string $filename): self
    {
        $filename = filter_var(preg_replace('/\s/', '_', $filename), FILTER_SANITIZE_STRING);
        if (!$filename) {
            throw new FileUploadException('Invalid filename');
        }
        $this->filename = $filename;
        return $this;
    }

    public function getFullFilename(): string
    {
        if (!$this->filename || !$this->extension) {
            throw new Exception('Filename parts missing');
        }

        return $this->filename . $this->extension;
    }

    public function save(): void
    {
        $filepath = $this->uploadPath . '/' . $this->filename . $this->extension;
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $filepath)) {
            throw new FileUploadException('Error uploading photo file');
        }
    }
}
