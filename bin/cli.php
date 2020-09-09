<?php

try {
    require __DIR__ . '/../vendor/autoload.php';

    unset($argv[0]);
    $params = [];

    // Составляем полное имя класса, добавив нэймспейс
    $className = '\\MyProject\\Cli\\' . array_shift($argv);

    if(!is_subclass_of($className, \MyProject\Cli\AbstractCommand::class)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" not valid class');
    }

    if (!class_exists($className)) {
        throw new \MyProject\Exceptions\CliException('Class "' . $className . '" not found');
    }

    foreach ($argv as $param) {
        $matches = [];
        if(preg_match('~^-(.*)=(.*)$~', $param, $matches)) {
            $params[$matches[1]] = $matches[2];
        }
    }

    $worker = new $className($params);
    $worker->execute();
} catch (\MyProject\Exceptions\CliException $e) {
    echo $e->getMessage();
}
