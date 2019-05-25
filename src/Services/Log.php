<?php


namespace App\Services;


use App\Libs\LoggManager\Interfaces\AbstractLog;

class Log
{

    public function success(AbstractLog $log)
    {
        //todo update info log
    }

    public function error(AbstractLog $log)
    {
        //todo update error log
    }

    public function info(AbstractLog $log)
    {
        //todo update info log
        $this->save();
    }

    protected function save()
    {
        //todo save db log
    }

}