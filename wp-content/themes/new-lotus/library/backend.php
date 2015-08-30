<?php

if (!function_exists('kopa_build_query')) {

    /**
     * @package Kopa
     * @subpackage Revant
     * @author: kopatheme
     * @description: build query args
     */
    function kopa_build_query($instance, $args_extra = array()) {
        $query_args = array(
            'post_type' => array('post'),
            'posts_per_page' => (int) $instance['posts_per_page'],
            'post_status' => array('publish'),
            'ignore_sticky_posts' => true,
        );

        if (count($instance['categories']) == 1 && $instance['categories'][0] == '') {
            $instance['categories'] = array();
        }

        if (count($instance['tags']) == 1 && $instance['tags'][0] == '') {
            $instance['tags'] = array();
        }

        if ($instance['categories']) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $instance['categories'],
            );
        }

        if ($instance['tags']) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'post_tag',
                'field' => 'id',
                'terms' => $instance['tags'],
            );
        }

        if (isset($instance['post_format']) && !empty($instance['post_format'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => $instance['post_format']
            );
        }

        if (isset($query_args['tax_query']) && count($query_args['tax_query']) >= 2) {
            $query_args['tax_query']['relation'] = $instance['relation'];
        }

        if (isset($instance['orderby'])) {
            switch ($instance['orderby']) {
                case 'comment_count':
                    $query_args['orderby'] = 'comment_count';
                    break;
                case 'rand':
                    $query_args['orderby'] = 'rand';
                    break;
                case 'ID':
                    $query_args['orderby'] = 'ID';
                    break;
                case 'title':
                    $query_args['orderby'] = 'title';
                    break;
                case 'popular':
                    $query_args['meta_key'] = 'kopa_' . 'new-lotus' . '_total_view';
                    $query_args['orderby'] = 'meta_value_num';
                    break;
                default:
                    $query_args['orderby'] = 'date';
                    break;
            }
        } else {
            $query_args['orderby'] = 'date';
        }
        if (isset($instance['order'])) {
            $query_args['order'] = $instance['order'];
        }


        global $wp_version;

        if (version_compare($wp_version, '3.7', '>=')) {
            if (isset($instance['timestamp']) && !empty($instance['timestamp'])) {
                $timestamp = $instance['timestamp'];
                $y = date('Y', strtotime($timestamp));
                $m = date('m', strtotime($timestamp));
                $d = date('d', strtotime($timestamp));

                $query_args['date_query'] = array(
                    array(
                        'after' => array(
                            'year' => (int) $y,
                            'month' => (int) $m,
                            'day' => (int) $d
                        )
                    )
                );
            }
        }

        if (!empty($args_extra)) {
            return array_merge($query_args, $args_extra);
        } else {
            return $query_args;
        }
    }
}
