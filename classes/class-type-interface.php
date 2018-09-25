<?php

namespace Develon674\TestSite2;

/**
 * Description of class-type-interface
 *
 * @author buzz2
 */
interface Type_Interface {
    public function __construct(string $text_domain, string $name, array $args = []);

    public function run();

    public function returnFunction();
}
