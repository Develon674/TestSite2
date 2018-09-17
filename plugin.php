<?php

/**
 * Plugin Name: Test Plugin
 * Author:      William Roberts
 * Description: This is my test plugin for the dev branch
 * Version: 0.1.1
 * Text Domain: test-plugin 
 */
use Dhii\Cache\MemoryMemoizer;
use Dhii\Di\CachingContainer;
use Develon674\TestSite2\MyPlugin;

require_once('vendor/autoload.php');

$services = require('services.php');

$cache = new MemoryMemoizer();

$container = new CachingContainer($services(__DIR__), $cache);

$plugin = new MyPlugin($container);




$plugin->run();
