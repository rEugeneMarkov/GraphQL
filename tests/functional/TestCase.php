<?php

namespace Tests\Functional;

use Database\DatabaseSeeder;
use Database\DatabaseMigrator;
use PHPUnit\Framework\TestCase as BaseCase;

abstract class TestCase extends BaseCase
{
    private static bool $initialized = false;

    public function setUp(): void
    {
        if (! self::$initialized) {
            // We utilize the filesystem as shared mutable state to coordinate between processes
            touch('/tmp/test-initialization-lock-file');
            $lockFile = fopen('/tmp/test-initialization-lock-file', 'r');

            // Attempt to get an exclusive lock - first process wins
            if (flock($lockFile, LOCK_EX | LOCK_NB)) {
                // Since we are the single process that has an exclusive lock, we run the initialization
                self::initialize();
            } else {
                // If no exclusive lock is available, block until the first process is done with initialization
                flock($lockFile, LOCK_SH);
            }

            self::$initialized = true;
        }
    }

    public static function initialize()
    {
        $enviroment = 'testing';
        DatabaseMigrator::rollbackAllMigrations($enviroment);
        DatabaseMigrator::migrate($enviroment);
        DatabaseSeeder::seed($enviroment);
    }
}
