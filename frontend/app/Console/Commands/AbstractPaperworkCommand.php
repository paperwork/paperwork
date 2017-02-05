<?php

namespace Paperwork\App\Commands;

use Illuminate\Console\Command;

abstract class AbstractPaperworkCommand extends Command {

    /**
     * Detect if php is running on windows.
     *
     * @return bool
     */
    public static function isWindows()
    {
        return substr(strtolower(PHP_OS), 0, 3) == 'win';
    }

    /**
     * Cross-platform executable path resolve.
     *
     * @param string $executable
     *   Executable name to resolve.
     *
     * @return bool|mixed
     *   Full path or false.
     */
    public static function resolveExecutable($executable)
    {
        $executable = preg_replace('/[^a-z0-9_-]/', '', $executable);

        $resolver = self::isWindows() ? 'where' : 'type';

        $resolve = `$resolver $executable`;

        if (self::isWindows()) {
            if (strpos($resolve, $executable) !== false) {
                return $resolve;
            }

            return false;
        }

        return strpos($resolve, 'not found') === false ? str_replace("$executable is ", '', trim($resolve)) : false;
    }

    /**
     * @return array
     */
    public static function checkRequiredCommands()
    {
        $commands_required = ['git', 'npm', 'composer'];

        $sufficient = true;

        foreach ($commands_required as $command) {
            $sufficient = AbstractPaperworkCommand::resolveExecutable($command) !== false;

            if (!$sufficient) {
                echo 'Required command not found: ' . $command . PHP_EOL;

                break;
            }
        }
        return $sufficient;
    }

    /**
     * @param $scripts
     */
    public static function batchRun(array $scripts)
    {
        foreach ($scripts as $command) {
            printf("Running %s\n", $command);

            $result = system($command, $return);

            if ($return == 0) {
                echo $result . PHP_EOL;
            } else {
                echo "Command returned $result" . PHP_EOL;

                exit(1);
            }
        }
    }
}