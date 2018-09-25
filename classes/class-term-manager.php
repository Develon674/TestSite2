<?php

namespace Develon674\TestSite2;

/**
 * This will create a hierarchy of terms from a list.
 *
 */
class Term_Manager {

    /**
     * 
     * @param WP_Term[] $terms
     * @return WP_Term[] List of terms by ID.
     */
    public function indexTermsById($terms) {
        $index = [];
        foreach ($terms as $term) {
            $index[$term->term_id] = $term;
        }
        return $index;
    }

    /**
     * 
     * @param WP_Term[] $terms 
     * 
     */
    public function getTermTree(array $terms, $parentId = 0) {
        $branch = [];

        foreach ($terms as $term) {
            /* @var $term WP_Term */
            if ($term->parent == $parentId) {
                $term->icon = wp_get_attachment_image_url($this->getTermMeta($term->term_id, 'posts_term_icon'), 'full');
                $term->question = $this->getTermMeta($term->term_id, 'posts_term_question');
                $term->answer = $this->getTermMeta($term->term_id, 'posts_term_answer');
                $children = $this->getTermTree($terms, $term->term_id);
                if ($children) {
                    $term->children = $children;
                }
                $branch[$term->term_id] = $term;
                unset($terms[$term->term_id]);
            }
        }
        return $parentId === 0 ? array_shift($branch) : $branch;
    }

    protected function getTermMeta($id, $key) {
        return get_term_meta($id, $key, true);
    }
    
}
