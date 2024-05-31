<?php
namespace Views;

class RegisterForm {
    public function initForm () {
        echo '<div class="register-form-container">
            <h1>Create an account</h1>
            <form method="post" class="register-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="mail">Mail</label>
                    <input type="email" name="mail" id="mail" required>
                </div>
                <div class="form-group">
                    <label for="pswd">Password</label>
                    <input type="password" name="pswd" id="pswd" required>
                </div>
                <button type="submit">Send</button>
            </form>
        </div>';
    }
}
?>