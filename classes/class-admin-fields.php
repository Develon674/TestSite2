<?php

namespace Develon674\TestSite2;

use Carbon_Fields\Container\Container;
use Carbon_Fields\Field\Field;

class Admin_Fields {

    protected $text_domain;
    protected $fields;
    protected $terms;

    public function __construct(string $text_domain, array $fields, $terms) {
        $this->text_domain = $text_domain;
        $this->fields = $fields;
        $this->terms = $terms;
    }

    public function run() {
        add_action('after_setup_theme', function() {
            \Carbon_Fields\Carbon_Fields::boot();
        });
        add_action('carbon_fields_register_fields', function() {
            $this->themeOptions();
        });
    }

    protected function container(string $c_type, string $c_name) {
        return Container::make($c_type, $c_name);
    }

    protected function field(string $f_type, string $f_key, string $f_name) {
        return Field::make($f_type, "{$this->text_domain}_{$f_key}", $f_name);
    }

    protected function themeOptions() {
        $top_container = $this->container('theme_options', 'Product Finder');
        $top_container->add_fields([
            $this->field('select', 'parent_cat_select', 'Select root category')
                ->add_options(function() {
                    return $this->filterTerms();
                }),
        ]);
    }

    public function filterTerms() {
        $terms = $this->terms;
        $term_options = [];
        foreach ($terms as $term) {
            $term_options[$term->slug] = $term->name;
        }
        return $term_options;
    }

}
