<header>
    <a href="">Home</a>
    <a href="notes">Notes</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="tasks">Todo-List</a>
        <a href="account">Account</a>
        <a href="login">Logout</a>
    <?php else: ?>
        <a href="login">Login</a>
        <a href="register">Sign Up</a>
    <?php endif; ?>
</header>