<?php
/**
 * Plugin Name: Test Plugin
 * Author:      William Roberts
 * Description: This is my test plugin
 * Version: 0.1.1
 */
 
 namespace Will\MyLib;
 
 abstract class Person {
	    protected $name;
	public function __construct(string $name) {
		$this-> name = $name;	
	}
	public function sayHello($target) {
		$this->obtainName();	
	}
	protected function getName() {
		return 'Hello: '.$this->name;	
	}
 }
 
 $person_1 = new Person('John');
 var_dump($person_1->getName());
