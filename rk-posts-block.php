<?php
/**
 * Plugin Name: Rannk Posts Block
 * Description: Display a listing of posts using the [rk-pb] shortcode
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

//插件启用时检测数据库
register_activation_hook( __FILE__, 'posts_block_install');
function posts_block_install() {
    global $wpdb;
    $sql = "CREATE TABLE IF NOT EXISTS `".$wpdb->base_prefix."rk_posts_block` (
            `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
            `title` varchar(100) NOT NULL DEFAULT '',
            `description` varchar(500) NOT NULL DEFAULT '',
            `content` text NOT NULL,
            `addtime` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $wpdb->query($sql);
}


add_shortcode( 'rk-pb', 'rk_block_display_posts_shortcode' );

function rk_block_display_posts_shortcode($atts) {

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

add_action( 'admin_menu', 'rk_create_menu' );
function rk_create_menu()
{
    $parent = 'edit.php';
    add_submenu_page($parent, "Posts Block", "Posts Block", "manage_options", "rk_block_posts_lists", 'rk_block_posts_lists');
}

function rk_block_posts_lists() {
    $action = $_REQUEST['action'];
    switch($action){
        case "form":
            rk_block_form();
            break;
        case "post_form":
            rk_post_form();
            break;
        default:
            rk_block_lists();
    }
}

function rk_block_lists() {
    global $wpdb;
    $limit_num = 20;
    $page_n = ceil($_REQUEST['n']);
    $page_n = ($page_n>1)?$page_n:1;
    $start_num = ($page_n - 1) * $limit_num;

    // 排序设置
    $sort = ($_REQUEST['order'] == "asc")?"asc":"desc";
    switch($_REQUEST['o_name']) {
        case "id":
            $sql_order = "order by id ".$sort;
            break;
        case "title":
            $sql_order = "order by title ".$sort;
            break;
    }

    $sql = "select * from " . $wpdb->base_prefix . "rk_posts_block";

    include("view/lists.php");
}

/**
 * 编辑添加表单
 */
function rk_block_form() {
    global $wpdb;
    $id = ceil($_REQUEST['id']);
    if($id > 0) {
        $sql = "select * from " . $wpdb->base_prefix . "rk_posts_block where id=$id";
        $block_row = $wpdb->get_row($sql, ARRAY_A);
    }

    include("view/form.php");
}

function rk_post_form() {
    global $wpdb;

    $data['title'] = trim($_POST['title']);
    $data['description'] = trim($_POST['description']);
    $data['content'] = trim($_POST['content']);
    $data['time'] = time();
    $id = ceil($_POST['id']);

    if($data['title'] == ""  || $data['content'] == ""){
        $msg = "名称或者模板内容没有填写";
        $go = "back";
    }else {
        foreach($data as $k => $v) {
            $fields = $k . "='" . addslashes($v) . "',";
        }

        $fields = substr($fields, 0, -1);

        $sql = "REPLACE " . $wpdb->base_prefix . "rk_posts_block set id=".$id.", " . $fields;

        $r = $wpdb->query($sql);

        if($r) {
            $msg = "添加/编辑成功";
            $go = "/wp-admin/edit.php?page=rk_block_posts_lists";
        }else {
            $msg = "数据保存错误";
            $go = "back";
        }

    }
    include("view/msg.php");
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