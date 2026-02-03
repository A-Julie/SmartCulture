<?php
// includes/security.php

/**
 * Système anti-brute force pour la connexion
 */
class LoginSecurity {
    private $pdo;
    private $max_attempts = 5; // Nombre max de tentatives
    private $lockout_time = 900; // 15 minutes en secondes
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->createTableIfNotExists();
    }
    
    /**
     * Créer la table de suivi des tentatives si elle n'existe pas
     */
    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS login_attempts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            email VARCHAR(255),
            attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            success BOOLEAN DEFAULT FALSE,
            INDEX idx_ip (ip_address),
            INDEX idx_time (attempt_time)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        try {
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            error_log("Erreur création table login_attempts: " . $e->getMessage());
        }
    }
    
    /**
     * Obtenir l'IP du visiteur
     */
    private function getIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    /**
     * Vérifier si l'IP est bloquée
     */
    public function isBlocked() {
        $ip = $this->getIP();
        $cutoff_time = date('Y-m-d H:i:s', time() - $this->lockout_time);
        
        $query = "SELECT COUNT(*) as attempts FROM login_attempts 
                  WHERE ip_address = :ip 
                  AND success = FALSE 
                  AND attempt_time > :cutoff";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'ip' => $ip,
            'cutoff' => $cutoff_time
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['attempts'] >= $this->max_attempts;
    }
    
    /**
     * Obtenir le temps restant de blocage
     */
    public function getBlockedTimeRemaining() {
        $ip = $this->getIP();
        $cutoff_time = date('Y-m-d H:i:s', time() - $this->lockout_time);
        
        $query = "SELECT MAX(attempt_time) as last_attempt FROM login_attempts 
                  WHERE ip_address = :ip 
                  AND success = FALSE 
                  AND attempt_time > :cutoff";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'ip' => $ip,
            'cutoff' => $cutoff_time
        ]);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['last_attempt']) {
            $last_attempt_time = strtotime($result['last_attempt']);
            $unlock_time = $last_attempt_time + $this->lockout_time;
            $remaining = $unlock_time - time();
            
            if ($remaining > 0) {
                return ceil($remaining / 60); // Retourner en minutes
            }
        }
        
        return 0;
    }
    
    /**
     * Enregistrer une tentative de connexion
     */
    public function recordAttempt($email, $success) {
        $ip = $this->getIP();
        
        $query = "INSERT INTO login_attempts (ip_address, email, success) 
                  VALUES (:ip, :email, :success)";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'ip' => $ip,
            'email' => $email,
            'success' => $success ? 1 : 0
        ]);
    }
    
    /**
     * Réinitialiser les tentatives après connexion réussie
     */
    public function resetAttempts() {
        $ip = $this->getIP();
        
        $query = "DELETE FROM login_attempts 
                  WHERE ip_address = :ip 
                  AND success = FALSE";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['ip' => $ip]);
    }
    
    /**
     * Nettoyer les anciennes tentatives (à appeler périodiquement)
     */
    public function cleanOldAttempts() {
        $cutoff_time = date('Y-m-d H:i:s', time() - (86400 * 7)); // 7 jours
        
        $query = "DELETE FROM login_attempts WHERE attempt_time < :cutoff";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['cutoff' => $cutoff_time]);
    }
}
?>