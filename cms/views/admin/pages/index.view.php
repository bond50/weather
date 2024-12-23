<h1>
    Admin : Mange pages
</h1>

<a href="index.php?route=admin/pages/create">Create page</a>
<table style="min-width: 100%">
    <thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($pages as $p): ?>
        <tr>
            <td><?= e($p->id) ?></td>
            <td><?= e($p->title) ?></td>
            <td>
                <a href="index.php?<?= http_build_query(['route' => 'admin/pages/edit', 'id' => $p->id]) ?>">Edit</a>
                <form style="display: inline"
                      method="post"
                      action="index.php?<?= http_build_query(['route' => 'admin/pages/delete']) ?>">
                    <input type="hidden" name="id" value="<?= e($p->id) ?>">
                    <input type="submit" value="Delete" class="btn-link">
                </form>
            </td>


        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
