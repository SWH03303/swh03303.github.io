<?php
declare(strict_types = 1);

const MIGRATIONS_TABLE = '__migrations';
const COMPONENTS_DIR = __DIR__ . '/parts';
const PAGES_DIR = __DIR__ . '/routes';
define('DATABASE_URL', dirname(__DIR__) . '/db.sqlite');
define('MIGRATIONS_DIR', dirname(__DIR__) . '/migrations');

foreach (['database', 'render', 'router', 'session', 'utils'] as $module) {
	require __DIR__ . "/core/$module.php";
}
