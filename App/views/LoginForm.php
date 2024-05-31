<?php
namespace Views;

class LoginForm {
    public function render() {
        if (isset($_SESSION['user_id'])) {
            echo '
            <div class="login-form-container">
                <form method="post" action="?action=logout" class="login-form">
                    <p>Want to disconnect, ' . htmlspecialchars($_SESSION['username']) . '?</p>
                    <button type="submit">Logout</button>
                </form>
            </div>';
        } else {
            echo '<div class="login-form-container">
                <h1>Login</h1>
                <form method="post" action="?action=login" class="login-form">
                    <div class="form-group">
                        <label for="mail">Mail</label>
                        <input type="email" name="mail" id="mail" required>
                    </div>
                    <div class="form-group">
                        <label for="pswd">Password</label>
                        <input type="password" name="pswd" id="pswd" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
            </div>';
        }
    }
}
?>