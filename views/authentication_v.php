<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - SmartCulture</title>
    <link rel="stylesheet" href="../style/authentication.css">
</head>
<body>
    <body>
  
    <?php if (!empty($_SESSION['flash_success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const msg = <?= json_encode($_SESSION['flash_success']) ?>;
            alert(msg);
            if (typeof openModal === 'function') {
                openModal('login');
            }
        });
    </script>
    <?php unset($_SESSION['flash_success']); ?>
<?php endif; ?>
    <div class="auth-container">
        <div class="tabs">
            <button class="tab active" onclick="switchTab('login')">Connexion</button>
            <button class="tab" onclick="switchTab('register')">Inscription</button>
        </div>
        
        <div class="tab-content">
            <!-- PANNEAU CONNEXION -->
            <div id="login-panel" class="form-panel active">
                <div class="logo">🎬</div>
                <h2>Bienvenue sur SmartCulture</h2>
                <?php if (isset($error) && !isset($_GET['register'])): ?>
    <div class="error">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="success">✅ <?= htmlspecialchars($success) ?></div>
<?php endif; ?>
                
                <form method="POST" action="../controllers/authentication_c.php?action=login">
                    <div class="form-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" required placeholder="votre@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="login-password">Mot de passe</label>
                        <input type="password" id="login-password" name="password" required placeholder="••••••••">
                    </div>
                    
                    <button type="submit">Se connecter</button>
                </form>
            </div>
            
            <!-- PANNEAU INSCRIPTION -->
            <div id="register-panel" class="form-panel">
                <div class="logo">📝</div>
                <h2>Créer un compte</h2>
                <?php if (isset($error) && isset($_GET['register'])): ?>
    <div class="error">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>
                <?php if (isset($error) && isset($_GET['register'])): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form method="POST" action="../controllers/authentication_c.php?action=register">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" required placeholder="Dupont">
                        </div>
                        
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" required placeholder="Jean">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="email" required placeholder="votre@email.com">
                    </div>
                    
        <div class="form-group">
            <label for="role">Votre role</label>
            <select id="role" name="role" required>
                <option value="user">👤 Utilisateur</option>
                <option value="admin">👑 Administrateur</option>
            </select>
        </div>
                    <div class="form-group">
                        <label for="register-password">Mot de passe</label>
                        <input type="password" id="register-password" name="password" required minlength="6" placeholder="••••••••">
                        <div class="password-hint">Minimum 6 caractères</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm-password">Confirmer le mot de passe</label>
                        <input type="password" id="confirm-password" name="confirm_password" required minlength="6" placeholder="••••••••">
                    </div>
                    
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function switchTab(tab) {
            // Mettre à jour les boutons d'onglets
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');
            
            // Mettre à jour les panneaux
            document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
            document.getElementById(tab + '-panel').classList.add('active');
        }
        
        // Si on vient de l'inscription avec une erreur, afficher l'onglet inscription
        <?php if (isset($_GET['register']) || (isset($error) && strpos($error, 'inscription') !== false)): ?>
        window.onload = function() {
            document.querySelector('.tab:last-child').click();
        };
        <?php endif; ?>
    </script>
</body>
</html>

<?php
// function isLoggedIn() {
//     global $connexion;
    
//     if (!isLoggedIn()) {
//         return null;
//     }
    
//     $user_id = $_SESSION['user_id'];
//     $query = "SELECT * FROM utilisateurs WHERE id_utilisateur = ?";
//     $stmt = mysqli_prepare($connexion, $query);
//     mysqli_stmt_bind_param($stmt, "i", $user_id);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
    
//     return mysqli_fetch_assoc($result);
//}