<h1>Edit page</h1>

<?php if (!empty($errors)): ?>
    <ul class="errors">
        <?php foreach ($errors as $error): ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="index.php?<?= e(http_build_query(['route' => 'admin/pages/edit', 'id' => $page->id])) ?>" method="post">
    <label for="title">Title:</label>
    <input
            type="text"
            name="title"
            id="title"
            value="<?php
            if (isset($_POST['title'])) echo e($_POST['title']); else echo e($page->title) ?>"/>


    <label for="content">Content:</label>
    <textarea name="content"
              id="content"><?php if (isset($_POST['content'])) echo e($_POST['content']); else echo e($page->content) ?></textarea>
    <input type="hidden" name="_csrf" value="<?php echo e(csrf_token()) ?>">

    <input type="submit" name="submit" value="submit !">
</form>
