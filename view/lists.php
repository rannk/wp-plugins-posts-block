<div class="wrap">
    <h1 class="wp-heading-inline">文章区块模板</h1>
    <a href="/wp-admin/edit.php?page=rk_block_posts_lists&action=form" class="page-title-action">添加新模板</a>
</div>
<div id="col-container" class="wp-clearfix">
    <div class="col-wrap">
        <form id="posts-filter" method="post" action="/wp-admin/edit.php?page=rk_block_posts_lists">
            <div class="tablenav top">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label>
                    <select name="action" id="bulk-action-selector-top">
                        <option value="-1">批量操作</option>
                        <option value="delete">删除</option>
                    </select>
                    <input type="submit" id="doaction" class="button action" value="应用">
                </div>
                <div class="tablenav-pages no-pages"><span class="displaying-num">0项目</span>
    <span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
    <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
    <span class="paging-input">第<label for="current-page-selector" class="screen-reader-text">当前页</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text">页，共<span class="total-pages">0</span>页</span></span>
    <a class="next-page" href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;paged=0"><span class="screen-reader-text">下一页</span><span aria-hidden="true">›</span></a>
    <a class="last-page" href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;paged=0"><span class="screen-reader-text">尾页</span><span aria-hidden="true">»</span></a></span></div>
                <br class="clear">
            </div>
            <h2 class="screen-reader-text">标签列表</h2><table class="wp-list-table widefat fixed striped tags">
                <thead>
                    <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                    <th scope="col" id="name" class="manage-column column-id sortable desc"  style="width: 10%">
                        <a href="/wp-admin/edit.php?page=rk_block_posts_lists&o_name=id&order=asc"><span>ID</span><span class="sorting-indicator"></span></th>
                    <th scope="col" id="description" class="manage-column sortable desc">
                        <a href="/wp-admin/edit.php?page=rk_block_posts_lists&o_name=title&order=asc"><span>名称</span><span class="sorting-indicator"></span></a></th>
                    <th scope="col" id="slug" class="manage-column">
                        <span>描述</span></th>
                    </tr>
                </thead>

                <tbody id="the-list">
                <?php
                for($i=0;$i<count($lists);$i++) {
                    $v = $lists[$i];
                    ?>
                    <tr id="tag-1">
                        <th scope="row" class="check-column">
                            <label class="screen-reader-text" for="cb-select-<?=$v['id']?>">选择 <?=$v['title']?></label>
                            <input id="cb-select-<?=$v['id']?>" type="checkbox" name="post[]" value="<?=$v['id']?>">
                        </th>
                        <td data-colname="名称">
                            <strong><?= $v['id'] ?></strong>
                            <div class="row-actions">
                                <span class="edit"><a href="/wp-admin/edit.php?page=rk_block_posts_lists&action=form&id=<?=$v['id']?>" aria-label="编辑“未分类”">编辑</a></span>
                            </div>
                        </td>
                        <td class="description column-description" data-colname="名称"><?= stripslashes($v['title'])?></td>
                        <td class="slug column-slug" data-colname="描述"><?=stripslashes($v['description'])?></td>
                    </tr>
                <?php
                }
                ?>
                <?php
                if (ceil($lists_num) == 0) {
                    echo '<tr class="no-items"><td class="colspanchange" colspan="4">未找到模板。</td></tr>';
                }
                ?>
                </tbody>

                <tfoot>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td>
                    <th scope="col" id="name" class="manage-column column-id sortable desc">
                        <a href="/wp-admin/edit.php?page=rk_block_posts_lists&o_name=id&order=asc"><span>ID</span><span class="sorting-indicator"></span></th>
                    <th scope="col" id="description" class="manage-column sortable desc">
                        <a href="/wp-admin/edit.php?page=rk_block_posts_lists&o_name=title&order=asc"><span>名称</span><span class="sorting-indicator"></span></a></th>
                    <th scope="col" id="slug" class="manage-column">
                        <span>描述</span></th>
                </tr>
                </tfoot>

            </table>
            <div class="tablenav bottom">

                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-bottom" class="screen-reader-text">选择批量操作</label><select name="action2" id="bulk-action-selector-bottom">
                        <option value="-1">批量操作</option>
                        <option value="delete">删除</option>
                    </select>
                    <input type="submit" id="doaction2" class="button action" value="应用">
                </div>
                <div class="tablenav-pages <?php if($lists_num == 0) echo "no-page"?>"><span class="displaying-num"><?=$lists_num?>项目</span>
    <span class="pagination-links">

        <?php
        if($page_n == 1) {
            echo '<span class="tablenav-pages-navspan" aria-hidden="true">«</span>';
        }else {
            echo '<a class="last-page" href="'.$link.'&n=1"><span aria-hidden="true">«</span></a>';
        }
        if(($page_n - 1)>0) {
            echo '<a class="next-page" href="'.$link.'&n='.($page_n-1).'"><span class="screen-reader-text">上一页</span><span aria-hidden="true">‹</span></a>';
        }else{
            echo '<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>';
        }
        ?>
        <span class="screen-reader-text">当前页</span>
        <span id="table-paging" class="paging-input"><span class="tablenav-paging-text">第<?=$page_n?>页，共<span class="total-pages"><?=$total_page?></span>页</span></span>
        <?php
        if(($page_n+1) <= $total_page){
            echo '<a class="next-page" href="'.$link.'&n='.($page_n+1).'"><span aria-hidden="true">›</span></a>';
        }else{
            echo '<span class="tablenav-pages-navspan" aria-hidden="true">›</span>';
        }

        if($page_n >= $total_page) {
            echo '<span class="tablenav-pages-navspan" aria-hidden="true">»</span>';
        }else {
            echo '<a class="last-page" href="'.$link.'&n='.$total_page.'"><span aria-hidden="true">»</span></a>';
        }
        ?>

    </span></div>
                <br class="clear">
            </div>
    </div>
</div>