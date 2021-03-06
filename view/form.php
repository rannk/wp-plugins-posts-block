<div class="wrap">
    <h1>编辑区块模板</h1>
    <form name="edittag" id="edittag" method="post" action="edit.php?page=rk_block_posts_lists" class="validate">
        <input type="hidden" name="action" value="post_form">
        <input type="hidden" name="id" value="<?=$block_row['id']?>">
        <table class="form-table">
        <tbody><tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="name">名称</label></th>
                <td><input name="title" id="name" type="text" value="<?=stripslashes($block_row['title'])?>" size="40" aria-required="true">
                    <p class="description">在标签里面template属性填写的信息就是该名称。(请保持在30个字符内)</p></td>
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="slug">描述</label></th>
                <td><input name="description" type="text" value="<?=stripslashes($block_row['description'])?>" size="40">
                    <p class="description">说明一下该模板具体派什么用处。</p></td>
            </tr>
            <tr class="form-field term-description-wrap">
                <th scope="row"><label for="description">模板内容</label></th>
                <td><textarea name="content"  rows="10" cols="50" class="large-text"><?=stripslashes($block_row['content'])?></textarea>
                    <p class="description">模板中可以用以下变量代替文章相关信息
                    <br>
                        <br>{circle} 文章列表循环的标志，文章循环区域用{circle}{/circle}
                        <br>{post_title} 文章标题
                        <br>{post_link} 文章链接地址
                        <br>{date} 文章发布时间
                        <br>{thumbnail} 文章缩略图
                        <br>{author} 文章发布者
                        <br>{content} 文章正文内容
                    </p></td>
            </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="更新"></p></form>
</div>