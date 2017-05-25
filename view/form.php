<div class="wrap">
    <h1>编辑区块模板</h1>
    <form name="edittag" id="edittag" method="post" action="edit.php?page=rk_block_posts_lists" class="validate">
        <input type="hidden" name="action" value="post_form">
        <input type="hidden" name="id" value="<?=$block_row['id']?>">
        <table class="form-table">
        <tbody><tr class="form-field form-required term-name-wrap">
                <th scope="row"><label for="name">名称</label></th>
                <td><input name="title" id="name" type="text" value="<?=$block_row['title']?>" size="40" aria-required="true">
                    <p class="description">在标签里面template属性填写的信息就是该名称。</p></td>
            </tr>
            <tr class="form-field term-slug-wrap">
                <th scope="row"><label for="slug">描述</label></th>
                <td><input name="description" type="text" value="<?=$block_row['description']?>" size="40">
                    <p class="description">说明一下该模板具体派什么用处。</p></td>
            </tr>
            <tr class="form-field term-description-wrap">
                <th scope="row"><label for="description">模板内容</label></th>
                <td><textarea name="content"  rows="10" cols="50" class="large-text"><?=$block_row['content']?></textarea>
                    <p class="description">描述只会在一部分主题中显示。</p></td>
            </tr>
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="更新"></p></form>
</div>