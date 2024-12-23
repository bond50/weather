<h1>Create new page</h1>

<?php if (!empty($errors)): ?>
    <ul class="errors">
        <?php foreach ($errors as $error): ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="index.php?route=admin/pages/create" method="post">
    <label for="title">Title:</label>
    <input
            type="text"
            name="title"
            id="title"
            value="<?php
            if (!empty($_POST['title'])) echo e($_POST['title']); ?>"/>

    <label for="slug">Slug:</label>
    <input
            type="text"
            name="slug"
            id="slug"
            value="<?php
            if (!empty($_POST['slug'])) echo e($_POST['slug']); ?>"/>

    <label for="content">Content:</label>
    <textarea name="content" id="content"><?php if (!empty($_POST['content'])) echo e($_POST['content']); ?></textarea>

    <input type="submit" name="submit" value="submit !">
</form>
