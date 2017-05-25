<div id="col-container" class="wp-clearfix">
    <div class="col-wrap">
        <form id="posts-filter" method="post">
            <input type="hidden" name="taxonomy" value="post_tag">
            <input type="hidden" name="post_type" value="post">

            <input type="hidden" id="_wpnonce" name="_wpnonce" value="07e054a20d"><input type="hidden" name="_wp_http_referer" value="/wp-admin/edit-tags.php?taxonomy=post_tag">	<div class="tablenav top">

                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label><select name="action" id="bulk-action-selector-top">
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
                    <td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">全选</label><input id="cb-select-all-1" type="checkbox"></td><th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=name&amp;order=asc"><span>名称</span><span class="sorting-indicator"></span></a></th><th scope="col" id="description" class="manage-column column-description sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=description&amp;order=asc"><span>图像描述</span><span class="sorting-indicator"></span></a></th><th scope="col" id="slug" class="manage-column column-slug sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=slug&amp;order=asc"><span>别名</span><span class="sorting-indicator"></span></a></th><th scope="col" id="posts" class="manage-column column-posts num sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=count&amp;order=asc"><span>总数</span><span class="sorting-indicator"></span></a></th>	</tr>
                </thead>

                <tbody id="the-list" data-wp-lists="list:tag">
                <tr class="no-items"><td class="colspanchange" colspan="5">未找到标签。</td></tr>	</tbody>

                <tfoot>
                <tr>
                    <td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">全选</label><input id="cb-select-all-2" type="checkbox"></td><th scope="col" class="manage-column column-name column-primary sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=name&amp;order=asc"><span>名称</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-description sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=description&amp;order=asc"><span>图像描述</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-slug sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=slug&amp;order=asc"><span>别名</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-posts num sortable desc"><a href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;orderby=count&amp;order=asc"><span>总数</span><span class="sorting-indicator"></span></a></th>	</tr>
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
                <div class="tablenav-pages no-pages"><span class="displaying-num">0项目</span>
    <span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
    <span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
    <span class="screen-reader-text">当前页</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">第1页，共<span class="total-pages">0</span>页</span></span>
    <a class="next-page" href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;paged=0"><span class="screen-reader-text">下一页</span><span aria-hidden="true">›</span></a>
    <a class="last-page" href="http://www.wordpress.local/wp-admin/edit-tags.php?taxonomy=post_tag&amp;paged=0"><span class="screen-reader-text">尾页</span><span aria-hidden="true">»</span></a></span></div>
                <br class="clear">
            </div>

        </form>

        <div class="form-wrap edit-term-notes">
            <p>标签可以有选择性地转换成分类目录，请使用<a href="http://www.wordpress.local/wp-admin/import.php">标签到分类目录转换器</a>。</p>
        </div>
    </div>
</div>