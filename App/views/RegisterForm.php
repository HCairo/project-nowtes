<?php
namespace Views;

class RegisterForm {
    // Méthode pour initialiser le formulaire d'inscription
    public function initForm() {
        echo '<div class="register-form-container">
            <h1>Créer un compte</h1>
            <form method="post" class="register-form">
                <div class="form-group">
                    <label for="username">Nom d\'utilisateur</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label for="mail">Mail</label>
                    <input type="email" name="mail" id="mail" required>
                </div>
                <div class="form-group">
                    <label for="pswd">Mot de passe</label>
                    <input type="password" name="pswd" id="pswd" required>
                </div>
                <button type="submit">Envoyer</button>
            </form>
            <h2>Connexion avec : </h2>
            <a href="?action=googleAuth" class="google">Google</a>
        </div>';
        // Echo out environment variables for debugging
        echo '<p>Google Client ID: ' . $_ENV['GOOGLE_CLIENT_ID'] . '</p>';
        echo '<p>Google Client Secret: ' . $_ENV['GOOGLE_CLIENT_SECRET'] . '</p>';
        echo '<p>Google Redirect URI: ' . $_ENV['GOOGLE_REDIRECT_URI'] . '</p>';
    }
}