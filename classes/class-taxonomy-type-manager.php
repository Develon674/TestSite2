<?php

namespace Develon674\TestSite2;

/**
 * Description of class-taxonomy-type-manager
 *
 * @author buzz2
 */
class Taxonomy_Type_Manager implements Type_Interface {

    protected $name;
    protected $args;
    protected $text_domain;
    protected $post_type;

    public function __construct(string $text_domain, string $name, string $post_type, array $args = []) {
        $this->name = strtolower($name);
        $this->args = $args;
        $this->text_domain = $text_domain;
        $this->post_type = $post_type;
    }

    public function run() {
        add_action('init', function() {
            $this->create();
        });
    }

    public function returnFunction() {
        return $this->create();
    }

    protected function create() {

        $single_lower = $this->name;

        if (!taxonomy_exists($single_lower)) {

            $single = ucwords($single_lower);
            $plural = "{$single}s";
            $plural_lower = "{$single_lower}s";

            $labels = array(
                'name' => _x($plural, 'Taxonomy General Name', "{$this->text_domain}_{$single_lower}"),
                'singular_name' => _x($single, 'Taxonomy Singular Name', "{$this->text_domain}_{$single_lower}"),
                'menu_name' => __($plural, "{$this->text_domain}_{$single_lower}"),
                'all_items' => __("All {$plural}", "{$this->text_domain}_{$single_lower}"),
                'parent_item' => __("Parent {$single}", "{$this->text_domain}_{$single_lower}"),
                'parent_item_colon' => __("Parent {$single}:", "{$this->text_domain}_{$single_lower}"),
                'new_item_name' => __("New {$single} Name", "{$this->text_domain}_{$single_lower}"),
                'add_new_item' => __("Add New {$single}", "{$this->text_domain}_{$single_lower}"),
                'edit_item' => __("Edit {$single}", "{$this->text_domain}_{$single_lower}"),
                'update_item' => __("Update {$single}", "{$this->text_domain}_{$single_lower}"),
                'view_item' => __("View {$single}", "{$this->text_domain}_{$single_lower}"),
                'separate_items_with_commas' => __("Separate {$single_lower} with commas", "{$this->text_domain}_{$single_lower}"),
                'add_or_remove_items' => __("Add or remove {$single_lower}", "{$this->text_domain}_{$single_lower}"),
                'choose_from_most_used' => __('Choose from the most used', "{$this->text_domain}_{$single_lower}"),
                'popular_items' => __("Popular {$plural}", "{$this->text_domain}_{$single_lower}"),
                'search_items' => __("Search {$plural}", "{$this->text_domain}_{$single_lower}"),
                'not_found' => __('Not Found', "{$this->text_domain}_{$single_lower}"),
                'no_terms' => __("Search {$plural_lower}", "{$this->text_domain}_{$single_lower}"),
                'items_list' => __("{$plural} list", "{$this->text_domain}_{$single_lower}"),
                'items_list_navigation' => __("{$plural} list navigation", "{$this->text_domain}_{$single_lower}"),
            );
            $args = array(
                'labels' => $labels,
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'show_in_nav_menus' => true,
                'show_tagcloud' => true,
            );
            register_taxonomy("{$this->post_type}_{$single_lower}", [$this->post_type], array_merge($this->args, $args));
        }
    }

}
