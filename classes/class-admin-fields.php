<?php

namespace Develon674\TestSite2;

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

class Admin_Fields {

    protected $text_domain;
    protected $fields;

    public function __construct(string $text_domain, array $fields) {
        $this->text_domain = $text_domain;
        $this->fields = $fields;
    }

    public function run() {
        add_action('after_setup_theme', function() {
            \Carbon_Fields\Carbon_Fields::boot();
        });
        add_action('carbon_fields_register_fields', function() {
            $this->createFields();
        });
    }

    protected function container(string $c_type, string $c_name) {
        return Container::make($c_type, $c_name);
    }

    protected function field(string $f_type, string $f_key, string $f_name) {
        return Field::make($f_type, "{$this->text_domain}_{$f_key}", $f_name);
    }

    protected function createFields() {
        $top_container = $this->container('theme_options', 'Product Finder');
        $top_container->add_fields([
            $this->field('textarea', 'test_text', 'Test'),
        ]);
    }

}
