<?php if (!empty($loginError)) : ?>
    <ul class="errors">
        <li>Login failed, Ensure you enter correct login credentials</li>
    </ul>
<?php endif; ?>


<form action="index.php?<?= http_build_query(['route' => 'admin/login']) ?>" method="post">
    <label for="login-username">Username:</label>
    <input
            type="text"
            id="login-username"
            name="username"
            value="<?php if (!empty($_POST['username'])) echo e($_POST['username']) ?>">

    <label for="login-password">Password</label>
    <input
            type="password"
            id="login-password"
            name="password"
            value="">
    <br/>
    <input type="submit" value="Login!">
</form>
