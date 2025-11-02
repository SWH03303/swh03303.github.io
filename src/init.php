<?php
declare(strict_types = 1);

const MIGRATIONS_TABLE = '__migrations';
const COMPONENTS_DIR = __DIR__ . '/parts';
const PAGES_DIR = __DIR__ . '/routes';
define('ASSETS_DIR', dirname(__DIR__) . '/assets');
define('DATABASE_URL', dirname(__DIR__) . '/db.sqlite');
define('MIGRATIONS_DIR', dirname(__DIR__) . '/migrations');

foreach (glob(__DIR__ . "/core/*.php") as $module) { require $module; }
