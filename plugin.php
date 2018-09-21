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

$plugin_file = __FILE__;
$plugin_dir = dirname($plugin_file);

$container = new CachingContainer($services($plugin_dir, plugins_url('', $plugin_file)), $cache);

$plugin = new MyPlugin($container);

$plugin->run();
