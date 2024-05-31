<?php
namespace Views;

class AccountView {
    
    public function showAccount($user) {
        ?>
        <div class="account-container">
            <h1>User Profile</h1>
            <p>Username: <?= htmlspecialchars($user['username']) ?> <button onclick="showEditForm('username')">Modify</button></p>
            <form id="username-form" style="display:none;" method="post" action="">
                <input type="hidden" name="field" value="username">
                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>">
                <button type="submit">Save</button>
                <button type="button" onclick="hideEditForm('username')">Cancel</button>
            </form>

            <p>Mail: <?= htmlspecialchars($user['mail']) ?> <button onclick="showEditForm('mail')">Modify</button></p>
            <form id="mail-form" style="display:none;" method="post" action="">
                <input type="hidden" name="field" value="mail">
                <input type="email" name="mail" value="<?= htmlspecialchars($user['mail']) ?>">
                <button type="submit">Save</button>
                <button type="button" onclick="hideEditForm('mail')">Cancel</button>
            </form>

            <p>Password: ******** <button onclick="showEditForm('password')">Modify</button></p>
            <form id="password-form" style="display:none;" method="post" action="">
                <input type="hidden" name="field" value="password">
                <input type="password" name="old_password" placeholder="Old Password" required><br>
                <input type="password" name="new_password" placeholder="New Password" required><br>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br>
                <button type="submit">Save</button>
                <button type="button" onclick="hideEditForm('password')">Cancel</button>
            </form>
            <form action="billing">
            <button>Change billing</button>
            </form>
        </div>
        <script>
            function showEditForm(field) {
                document.getElementById(field + '-form').style.display = 'block';
            }
            function hideEditForm(field) {
                document.getElementById(field + '-form').style.display = 'none';
            }
        </script>
        <?php
    }
}