<?php
/**
 * Plugin Name: Test Plugin
 * Author:      William Roberts
 * Description: This is my test plugin for the dev branch
 * Version: 0.1.1
 * Text Domain: test-plugin 
 */

require_once('vendor/autoload.php');

use Dhii\Cache\MemoryMemoizer;
use Dhii\Di\CachingContainer;
use Develon674\TestSite2\MyPlugin;

$cache = new MemoryMemoizer();
$container = new CachingContainer([], $cache);

$plugin = new MyPlugin();




$plugin->run();
