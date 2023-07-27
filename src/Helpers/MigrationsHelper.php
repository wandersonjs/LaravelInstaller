<?php

namespace RachidLaasri\LaravelInstaller\Helpers;

use Illuminate\Support\Facades\DB;

trait MigrationsHelper
{
    /**
     * Get the migrations in /database/migrations.
     *
     * @return array Array of migrations name, empty if no migrations are existing
     */
    public function getMigrations()
    {
        
        $version = config('installer.currentVersion', 'v100');
        $getmigrations = glob(database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'*.php');
        $updateMigrations = glob(database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.$version.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'*.php');
        
        $migrations = array_merge($getmigrations, $updateMigrations);
        $migrations = str_replace(glob(database_path().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR), '', $migrations);
        $migrations = str_replace($version.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR, '', $migrations);
        $migrations = str_replace('.php', '', $migrations);
        
        return $migrations;
    }

    /**
     * Get the migrations that have already been ran.
     *
     * @return \Illuminate\Support\Collection List of migrations
     */
    public function getExecutedMigrations()
    {
        // migrations table should exist, if not, user will receive an error.
        return DB::table('migrations')->get()->pluck('migration');
    }
}
