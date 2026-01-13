<?php
function loginUser($pdo, $email, $password) {
    $query = "SELECT * FROM utilisateurs WHERE email = :email AND actif = TRUE";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        return $user;
    }
    
    return false;
}

function registerUser($pdo, $nom, $prenom, $email, $password) {
    try {
        // Vérifier si l'email existe déjà
        $check_query = "SELECT id_utilisateur FROM utilisateurs WHERE email = :email";
        $check_stmt = $pdo->prepare($check_query);
        $check_stmt->execute(['email' => $email]);
        
        if ($check_stmt->fetch()) {
            return false; // Email déjà existant
        }
        
        // Hasher le mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insérer le nouvel utilisateur
        $query = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, actif) 
                  VALUES (:nom, :prenom, :email, :password, TRUE)";
        $stmt = $pdo->prepare($query);
        
        return $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $hashed_password
        ]);
        
    } catch (PDOException $e) {
        error_log("Erreur d'inscription: " . $e->getMessage());
        return false;
    }
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserInfo() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'nom' => $_SESSION['user_nom'],
            'prenom' => $_SESSION['user_prenom'],
            'email' => $_SESSION['user_email']
        ];
    }
    return null;
}
?>