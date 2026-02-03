<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $status === 'success' ? 'Paiement réussi' : 'Erreur de paiement' ?> - SmartCulture</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .result-container {
            max-width: 600px;
            margin: 80px auto;
            padding: 40px;
            background: #181818;
            border-radius: 10px;
            text-align: center;
            border: 2px solid <?= $status === 'success' ? '#46d369' : '#e50914' ?>;
        }
        
        .result-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .result-title {
            font-size: 32px;
            color: <?= $status === 'success' ? '#46d369' : '#e50914' ?>;
            margin-bottom: 15px;
        }
        
        .result-message {
            color: #b3b3b3;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .order-details {
            background: #222222;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            text-align: left;
        }
        
        .order-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #2a2a2a;
        }
        
        .order-row:last-child {
            border-bottom: none;
        }
        
        .order-label {
            color: #808080;
        }
        
        .order-value {
            color: #e5e5e5;
            font-weight: bold;
        }
        
        .btn-return {
            display: inline-block;
            padding: 15px 40px;
            background: #e50914;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 20px;
        }
        
        .btn-return:hover {
            background: #f40612;
        }
        
        .btn-retry {
            display: inline-block;
            padding: 15px 40px;
            background: #2a2a2a;
            color: #e5e5e5;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin-top: 10px;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <?php if ($status === 'success' && isset($_SESSION['payment_success'])): ?>
        <div class="result-container">
            <div class="result-icon">✅</div>
            <h1 class="result-title">Paiement réussi !</h1>
            <p class="result-message">
                Votre commande a été confirmée et sera traitée dans les plus brefs délais.<br>
                Un email de confirmation vous a été envoyé.
            </p>
            
            <div class="order-details">
                <div class="order-row">
                    <span class="order-label">Numéro de commande</span>
                    <span class="order-value"><?= htmlspecialchars($_SESSION['order_number']) ?></span>
                </div>
                <div class="order-row">
                    <span class="order-label">Date</span>
                    <span class="order-value"><?= htmlspecialchars($_SESSION['order_date']) ?></span>
                </div>
                <div class="order-row">
                    <span class="order-label">Montant total</span>
                    <span class="order-value"><?= number_format($_SESSION['order_total'], 2, ',', ' ') ?> €</span>
                </div>
                <div class="order-row">
                    <span class="order-label">Statut</span>
                    <span class="order-value" style="color: #46d369;">Payée</span>
                </div>
            </div>
            
            <a href="catalogue_c.php" class="btn-return">Retour au catalogue</a>
            
            <script>
                // Vider le panier localStorage
                localStorage.removeItem('cart');
            </script>
        </div>
        <?php 
        // Nettoyer la session
        unset($_SESSION['payment_success']);
        unset($_SESSION['order_number']);
        unset($_SESSION['order_total']);
        unset($_SESSION['order_date']);
        ?>
        
    <?php else: ?>
        <div class="result-container">
            <div class="result-icon">❌</div>
            <h1 class="result-title">Échec du paiement</h1>
            <p class="result-message">
                <?= isset($_SESSION['payment_error']) ? htmlspecialchars($_SESSION['payment_error']) : 'Une erreur est survenue lors du traitement de votre paiement.' ?>
            </p>
            
            <p class="result-message" style="font-size: 14px;">
                Veuillez vérifier vos informations bancaires et réessayer.<br>
                Si le problème persiste, contactez votre banque.
            </p>
            
            <a href="catalogue_c.php" class="btn-return">Retour au catalogue</a>
            <a href="javascript:history.back()" class="btn-retry">Réessayer le paiement</a>
        </div>
        <?php unset($_SESSION['payment_error']); ?>
    <?php endif; ?>
</body>
</html>