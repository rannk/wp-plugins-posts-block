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
            `is_del` tinyint(4) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    $wpdb->query($sql);
}


add_shortcode( 'rk-pb', 'rk_block_display_posts_shortcode' );

function rk_block_display_posts_shortcode($atts) {

    $original_atts = $atts;

    $BP = new BlockPosts();

    $atts = shortcode_atts( array(
        'author' => '',
        'category' => '',
        'id' => false,
        'tag' => '',
        'template_id' => '',
        'template_title' => '',
        'order' => 'DESC',
        'orderby' => 'date',
        'date_format' => '(n/j/Y)',
        'posts_per_page' => '10',
        'post_type' => 'any'
    ), $atts, 'block-posts' );

    $category = sanitize_text_field( $atts['category'] );
    $date_format = sanitize_text_field( $atts['date_format'] );
    $temp_id = $atts['template_id'];
    $temp_title = $atts['template_title'];
    $order = $atts['order'];
    $orderby = $atts['orderby'];
    $tag = sanitize_text_field( $atts['tag'] );
    $id = $atts['id'];
    $posts_per_page = intval( $atts['posts_per_page'] );
    $post_type = $atts['post_type'];

    // Set up initial query for post
    $args = array(
        'category_name' => $category,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts_per_page,
        'tag' => $tag,
        'post_type' => $post_type
    );

    // If Post IDs
    if( $id ) {
        $posts_in = array_map( 'intval', explode( ',', $id ) );
        $args['post__in'] = $posts_in;
    }

    $listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $original_atts ));

    $index = 0;
    while ( $listing->have_posts() ){
        $listing->the_post();
        global $post;
        $lists[$index]['post_title'] = get_the_title();
        $lists[$index]['post_link'] = get_permalink();
        $lists[$index]['thumbnail'] = get_the_post_thumbnail( get_the_ID(), false);
        $lists[$index]['date'] = get_the_date( $date_format );
        $lists[$index]['author'] = get_the_author();
        $lists[$index]['content'] = get_the_content();
        $index++;
    }

    $BP->setTemplate($temp_id, $temp_title);
    $layer = $BP->getBlock($lists);

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
        case "delete":
            rk_del_posts();
            break;
        default:
            rk_block_lists();
    }
}

function rk_del_posts() {
    global $wpdb;
    $str = "";
    $msg = "没有选择要删除的模板";

    for($i=0;$i<count($_REQUEST['post']);$i++){
        $v = $_REQUEST['post'][$i];
        $v = ceil($v);
        $str .= $v .",";
    }

    if($str) {
        $str = substr($str, 0, -1);
        $sql = "update " . $wpdb->base_prefix . "rk_posts_block set is_del=1 where id in ($str)";
        if($wpdb->query($sql)){
            $msg = "删除成功";
        }else {
            $msg = "数据操作失败";
        }
    }

    $go = "/wp-admin/edit.php?page=rk_block_posts_lists";

    include("view/msg.php");
}

function rk_block_lists() {
    global $wpdb;
    $limit_num = 10;
    $page_n = ceil($_REQUEST['n']);
    $page_n = ($page_n>1)?$page_n:1;

    $sql = "select * from " . $wpdb->base_prefix . "rk_posts_block where is_del=0 ";

    $wpdb->get_results($sql);
    $lists_num = $wpdb->num_rows;
    $total_page = ceil($lists_num/$limit_num);

    if($page_n > $total_page) {
        $page_n = $total_page;
    }

    $start_num = ($page_n - 1) * $limit_num;
    $sql_limit = " limit $start_num, $limit_num";

    // 排序设置
    $sort = ($_REQUEST['order'] == "asc")?"asc":"desc";
    switch($_REQUEST['o_name']) {
        case "id":
            $sql_order = "order by id ".$sort;
            break;
        case "title":
            $sql_order = "order by title ".$sort;
            break;
        default:
            $sql_order = "order by addtime desc";
    }

    $lists = $wpdb->get_results($sql . $sql_order . $sql_limit, ARRAY_A);

    $link = "/wp-admin/edit.php?page=rk_block_posts_lists&o_name=".$_REQUEST['o_name']."&order=".$_REQUEST['order'];

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
    $data['addtime'] = time();
    $id = ceil($_POST['id']);

    if($data['title'] == ""  || $data['content'] == ""){
        $msg = "名称或者模板内容没有填写";
        $go = "back";
    }else {
        $fields = "";
        foreach($data as $k => $v) {
            $fields .= $k . "='" . addslashes($v) . "',";
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
    var $template_content;

    public function __construct() {

    }

    public function setTemplate($id, $title) {
        global $wpdb;

        $id = ceil($id);
        if($id > 0) {
            $sql = "select * from " . $wpdb->base_prefix . "rk_posts_block where id=$id";
            $row = $wpdb->get_row($sql, ARRAY_A);
            if($row['id']) {
                $this->template_content = stripslashes($row['content']);
                return true;
            }
        }

        if($title) {
            $sql = "select * from " . $wpdb->base_prefix . "rk_posts_block where title='".addslashes($title)."'";
            $row = $wpdb->get_row($sql, ARRAY_A);
            if($row['id']) {
                $this->template_content = stripslashes($row['content']);
                return true;
            }
        }
    }

    public function getTemplate() {
        if(!$this->template_content)
            $t = '<ul>{circle}<li><a href="{post_link}">{post_title}</a></li>{/circle}</ul>';
        else
            $t = $this->template_content;
        return $t;
    }


    public function getBlock($lists) {
        $t = $this->getTemplate();
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

        $p = $lists[0];
        if(count($p) > 0) {
            foreach($p as $field => $value) {
                $t = str_replace('{'.$field.'}', $value, $t);
            }
        }

        return $t;
    }
}