<?php


namespace App\Services;


use App\Libs\LoggManager\Interfaces\AbstractLog;

class Logger
{
    const SUCCESS   = 'success';
    const INFO      = 'info';
    const ERROR     = 'error';

    public function success(AbstractLog $log)
    {
        $this->save(Logger::SUCCESS, $log->getMessage());

        return $this;
    }

    public function error(AbstractLog $log)
    {
        $this->save(Logger::ERROR, $log->getMessage());

        return $this;
    }

    public function info(AbstractLog $log)
    {
        $this->save(Logger::INFO, $log->getMessage());

        return $this;
    }

    protected function save($status = Logger::INFO, $message)
    {

        //todo save db log
    }

}