<!-- TinyMCE -->
<script type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/js/tiny_mce/tinymce_config.js" ></script>
<!-- /TinyMCE -->
<?
if ($errors) {
    foreach ($errors as $error) {
        print '<div class="alert alert-error">' . $error . '</div>';
    }
}
?>

<form action="/admin/pages/add" method="post">
    <div class="border">
        <ul>
            <li>
                <?php if($all_pages) :?>
                <select name="page_id">
                    <option value="">
                        --Родительска страница--
                    </option>
                    <? foreach ($all_pages as $page): ?>
                        <option value="<?=$page->id ?>">
                            <?=str_repeat('&nbsp;', 2 * $page->lvl) . $page->page_title ?>
                        </option>
                    <? endforeach ?>
                </select>
                <?php endif;?>
            </li>
            <li>Название страницы <br><input class="span6" type="text" name="page_title" value="<?= $data['page_title'] ?>"></li>
            <li>Путь к странице <br><input class="span6" type="text" name="url" value="<?= $data['url'] ?>"></li>

            <li>Текст страницы<br>
                <textarea class="span6" id="elm1" name="page_content" ><?= $data['page_content'] ?></textarea>
            </li>
            <li>Статус <input  type="checkbox" name="page_status" checked="checked" value="1"></li>
            <li><input class="btn" type="submit" name="submit" value=" Сахранить "></li>
        </ul>
    </div>
</form>