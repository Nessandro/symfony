<?php


namespace App\Libs\LoggManager\Logs;


use App\Libs\LoggManager\Interfaces\AbstractLog;
use \Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileLog extends AbstractLog
{
    const TYPE_UPLOAD = "upload";
    const TYPE_MODIFY = "modify";

    protected $file;
    protected $type;

    public function __construct(UploadedFile $file, string $type = UploadFileLog::TYPE_UPLOAD)
    {
        $this->file = $file;
        $this->type = $type;
    }

    public function getMessage(): string
    {
        return "Place Holder";
    }
}