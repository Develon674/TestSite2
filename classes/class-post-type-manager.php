<?php

namespace Develon674\TestSite2;

/**
 * Description of class-post-type-manager
 *
 * @author Will
 */
class Post_Type_Manager {

    protected $cpt_name;
    protected $cpt_args;
    protected $text_domain;

    public function __construct(string $text_domain, string $cpt_name, array $cpt_args = []) {
        $this->cpt_name = strtolower($cpt_name);
        $this->cpt_args = $cpt_args;
        $this->text_domain = $text_domain;
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

        $single_lower = $this->cpt_name;

        if (!post_type_exists($single_lower)) {

            $single = ucwords($single_lower);
            $plural = "{$single}s";
            $plural_lower = "{$single_lower}s";

            $labels = array(
                'name' => _x($plural, 'Post Type General Name', "{$this->text_domain}_{$single_lower}"),
                'singular_name' => _x($single, 'Post Type Singular Name', "{$this->text_domain}_{$single_lower}"),
                'menu_name' => __($plural, "{$this->text_domain}_{$single_lower}"),
                'name_admin_bar' => __($single, "{$this->text_domain}_{$single_lower}"),
                'archives' => __("{$single} Archives", "{$this->text_domain}_{$single_lower}"),
                'attributes' => __("{$single} Attributes", "{$this->text_domain}_{$single_lower}"),
                'parent_item_colon' => __("Parent {$single}:", "{$this->text_domain}_{$single_lower}"),
                'all_items' => __("All {$plural}", "{$this->text_domain}_{$single_lower}"),
                'add_new_item' => __("Add New {$single}", "{$this->text_domain}_{$single_lower}"),
                'add_new' => __('Add New', "{$this->text_domain}_{$single_lower}"),
                'new_item' => __("New {$single}", "{$this->text_domain}_{$single_lower}"),
                'edit_item' => __("Edit {$single}", "{$this->text_domain}_{$single_lower}"),
                'update_item' => __("Update {$single}", "{$this->text_domain}_{$single_lower}"),
                'view_item' => __("View {$single}", "{$this->text_domain}_{$single_lower}"),
                'view_items' => __("View {$plural}", "{$this->text_domain}_{$single_lower}"),
                'search_items' => __("Search {$plural}", "{$this->text_domain}_{$single_lower}"),
                'not_found' => __('Not found', "{$this->text_domain}_{$single_lower}"),
                'not_found_in_trash' => __('Not found in Trash', "{$this->text_domain}_{$single_lower}"),
                'featured_image' => __("{$single} Image", "{$this->text_domain}_{$single_lower}"),
                'set_featured_image' => __("Set {$single_lower} image", "{$this->text_domain}_{$single_lower}"),
                'remove_featured_image' => __("Remove {$single_lower} image", "{$this->text_domain}_{$single_lower}"),
                'use_featured_image' => __("Use as {$single_lower} image", "{$this->text_domain}_{$single_lower}"),
                'insert_into_item' => __("Insert into {$single_lower}", "{$this->text_domain}_{$single_lower}"),
                'uploaded_to_this_item' => __("Uploaded to this {$single_lower}", "{$this->text_domain}_{$single_lower}"),
                'items_list' => __("{$plural} list", "{$this->text_domain}_{$single_lower}"),
                'items_list_navigation' => __("{$plural} list navigation", "{$this->text_domain}_{$single_lower}"),
                'filter_items_list' => __("{$plural} list navigation", "{$this->text_domain}_{$single_lower}"),
            );
            $args = array(
                'label' => __($plural, "{$this->text_domain}_{$single_lower}"),
                'description' => __("A custom post type for {$plural}", "{$this->text_domain}_{$single_lower}"),
                'labels' => $labels,
                'supports' => ['title', 'editor', 'thumbnail', 'revisions'],
                'taxonomies' => ['category', 'post_tag'],
                'hierarchical' => false,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'show_in_admin_bar' => true,
                'show_in_nav_menus' => true,
                'can_export' => true,
                'has_archive' => true,
                'exclude_from_search' => false,
                'publicly_queryable' => true,
                'capability_type' => 'page',
            );
            register_post_type($single_lower, array_merge($this->cpt_args, $args));
        }
    }

}
