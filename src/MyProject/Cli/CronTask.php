<?php


namespace MyProject\Cli;


class CronTask extends AbstractCommand
{

    public function execute()
    {
        $sleep =  $this->getParam('sleep');
        if($sleep) {
            sleep($sleep);
        }
        file_put_contents('C:\\1.log', date(DATE_ISO8601) . PHP_EOL, FILE_APPEND);
    }

    protected function checkParams()
    {
        // TODO: Implement checkParams() method.
    }
}