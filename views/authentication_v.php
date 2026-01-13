<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - SmartCulture</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .auth-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            overflow: hidden;
            width: 400px;
            max-width: 100%;
        }
        
        .tabs {
            display: flex;
            background: #f5f5f5;
            border-bottom: 2px solid #ddd;
        }
        
        .tab {
            flex: 1;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            background: #f5f5f5;
            color: #666;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            font-size: 15px;
        }
        
        .tab:hover {
            background: #e8e8e8;
        }
        
        .tab.active {
            background: white;
            color: #667eea;
            border-bottom: 3px solid #667eea;
        }
        
        .tab-content {
            padding: 40px;
        }
        
        .form-panel {
            display: none;
        }
        
        .form-panel.active {
            display: block;
            animation: fadeIn 0.4s;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 24px;
        }
        
        .logo {
            text-align: center;
            font-size: 48px;
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }
        
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        button[type="submit"]:active {
            transform: translateY(0);
        }
        
        .error {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #c33;
            font-size: 14px;
        }
        
        .success {
            background: #efe;
            color: #2d5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #2d5;
            font-size: 14px;
        }
        
        .form-row {
            display: flex;
            gap: 15px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .password-hint {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
    </style>
</head>
<body>
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
                
                <?php if (isset($error) && !isset($_GET['register'])): ?>
                    <div class="error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="success"><?= htmlspecialchars($success) ?></div>
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