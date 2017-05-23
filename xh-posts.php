<?php
/**
 * Plugin Name: posts block widget
 * Description: Display a listing of posts using the [block-posts] shortcode
 * Version: 1.0
 * Author: Rannk Deng
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright Copyright (c) 2011, Bill Erickson
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

add_shortcode( 'block-posts', 'block_display_posts_shortcode' );

function block_display_posts_shortcode($atts) {

    $original_atts = $atts;

    $BP = new BlockPosts();

    $atts = shortcode_atts( array(
        'author'               => '',
        'category'             => ''
    ), $atts, 'block-posts' );

    $category = sanitize_text_field( $atts['category'] );
    $date_format = sanitize_text_field( $atts['date_format'] );

    // Set up initial query for post
    $args = array(
        'category_name'       => $category
    );

    $listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $original_atts ));

    $index = 0;
    while ( $listing->have_posts() ){
        $listing->the_post();
        global $post;
        $lists[$index]['post_title'] = get_the_title();
        $lists[$index]['post_link'] = get_permalink();
        $lists[$index]['thumbnail'] = get_the_post_thumbnail( get_the_ID(), false);
        $lists[$index]['date'] = get_the_date( $date_format );
        $index++;
    }

    $layer = $BP->getBlock($lists, "");

    return $layer;
}

add_action( 'admin_menu', 'boj_menuexample_create_menu' );
function boj_menuexample_create_menu()
{
    global $page_hooks;
    //deal with custom type!
    $post_types = series_posttype_support();
    foreach ($post_types as $post_type) {
        $parent = 'edit.php';
        if ($post_type != 'post') {
            $parent .= '?post_type=' . $post_type;
        }
        $menu_slug = SERIES . '_bulk_edit_' . $post_type;
        $hook = add_submenu_page($parent, "Posts Block", "Posts Block", series_set_options_cap(), $menu_slug, 'series_edition_page');
        $page_hooks[$post_type] = $hook;
    }
}


class BlockPosts {
    public function __constrcut() {
        // Add the options page and menu item.
        add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
    }

    public function add_plugin_admin_menu() {

    }

    public function getTemplate($tag = "") {
        $t = '<ul>{circle}<li><a href="{post_link}">{post_title}</a></li>{/circle}</ul>';
        return $t;
    }


    public function getBlock($lists, $temp_tag) {
        $t = $this->getTemplate($temp_tag);
        $index = 0;
        while(strlen($t) > 0) {
            $s_p = stripos($t, '{circle}');
            if(!($s_p === false)) {
                $e_p = stripos($t, '{/circle}');
                if($e_p) {
                    $t_l[$index] = substr($t, $s_p+8, $e_p-$s_p-8);
                }else {
                    break;
                }
            }else {
                break;
            }
            $t = substr($t, 0, $s_p) . '{CC_'.$index.'}' . substr($t, $e_p+9);
            $index++;
        }

        $result_arr = array();
        if(count($t_l)>0) {
            foreach($t_l as $k => $v) {
                $str = "";
                for($i=0;$i<count($lists);$i++) {
                    $p = $lists[$i];
                    if(count($p) > 0) {
                        $element = $v;
                        foreach($p as $field => $value) {
                            $element = str_replace('{'.$field.'}', $value, $element);
                        }
                        $str .= $element;
                    }
                }
                $result_arr[$k] = $str;
            }
        }

        foreach($result_arr as $k => $v) {
            $t = str_replace('{CC_'.$k .'}', $v, $t);
        }

        return $t;
    }
}