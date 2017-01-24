<?php
/**
 * @author hollodotme <hw@hollo.me>
 */

namespace CodeClimate\PhpTestReporter;

use CodeClimate\PhpTestReporter\ConsoleCommands\RollbackCommand;
use CodeClimate\PhpTestReporter\ConsoleCommands\SelfUpdateCommand;
use CodeClimate\PhpTestReporter\ConsoleCommands\UploadCommand;
use Symfony\Component\Console\Application;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $app = new Application('Code Climate PHP Test Reporter', '@package_version@');
    $app->addCommands(
        array(
            new UploadCommand('upload'),
            new SelfUpdateCommand('self-update'),
            new RollbackCommand('rollback'),
        )
    );

    $code = $app->run();

    exit($code);
} catch (\Exception $e) {
    echo 'Uncaught Exception ' . get_class($e) . ' with message: ' . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString();

    exit(1);
}
