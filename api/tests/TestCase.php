<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://127.0.0.1:9999';

    /**
     * @var string
     */
    protected $now;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $this->now = \Carbon\Carbon::now()->format('d/m/Y H:i:s');

        $app = require __DIR__.'/../bootstrap/app-testing.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }

    public function setUp():void
    {
        parent::setUp();
        $this->setupDatabase();
    }

    /**
     * SetUp database
     */
    public function setupDatabase()
    {
        exec('cp ' . __DIR__ . '/../database/testing/stubdb.sqlite ' .
            __DIR__ .     '/../database/testing/testdb.sqlite');
        $this->artisan('migrate --seed');
        exec('php artisan migrate --seed --env=testing');
    }

    /**
     * Asserts that Jobs are in Queue to be dispatched.
     *
     * @param string $queued
     */
    public function assertQueued($queued)
    {
        $counter = DB::table("jobs")
                    //->where("payload", "LIKE", "%{$queued}%")
                    ->get();
        $this->assertEquals(1, $counter);
    }

    /**
     * @param string $table
     * @param string|int $id
     * @return bool
     */
    protected function updateCreatedAtUpdatedAtFromTable($table, $id)
    {
        DB::table($table)
            ->where('id', $id)
            ->update([
                'created_at' => \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $this->now),
                'updated_at' => \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $this->now)
            ]);
    }
}