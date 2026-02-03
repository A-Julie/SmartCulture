<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - SmartCulture</title>
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background: #181818;
            border-radius: 10px;
            border: 1px solid #2a2a2a;
        }
        
        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .payment-header h1 {
            color: #e5e5e5;
            margin-bottom: 10px;
        }
        
        .payment-total {
            font-size: 32px;
            color: #e50914;
            font-weight: bold;
            margin-top: 15px;
        }
        
        .cart-summary {
            background: #222222;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .cart-item-payment {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #2a2a2a;
        }
        
        .cart-item-payment:last-child {
            border-bottom: none;
        }
        
        .payment-form {
            margin-top: 30px;
        }
        
        .card-input {
            background: #222222;
            border: 1px solid #2a2a2a;
            color: #e5e5e5;
            padding: 12px 15px;
            border-radius: 6px;
            width: 100%;
            font-size: 15px;
            margin-bottom: 15px;
        }
        
        .card-input:focus {
            outline: none;
            border-color: #e50914;
        }
        
        .card-row {
            display: flex;
            gap: 15px;
        }
        
        .card-row .form-group {
            flex: 1;
        }
        
        .test-mode {
            background: #2a2a2a;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            border-left: 4px solid #ffa500;
        }
        
        .test-mode h3 {
            color: #ffa500;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .test-mode label {
            display: block;
            color: #e5e5e5;
            margin-bottom: 10px;
            cursor: pointer;
        }
        
        .test-mode input[type="radio"] {
            margin-right: 10px;
        }
        
        .btn-pay {
            width: 100%;
            padding: 15px;
            background: #e50914;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        
        .btn-pay:hover {
            background: #f40612;
        }
        
        .btn-cancel {
            width: 100%;
            padding: 12px;
            background: #2a2a2a;
            color: #e5e5e5;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 10px;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .secure-badge {
            text-align: center;
            color: #46d369;
            margin-top: 20px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="payment-header">
            <h1>💳 Paiement Sécurisé</h1>
            <div class="payment-total">Total : <?= number_format($total, 2, ',', ' ') ?> €</div>
        </div>
        
        <div class="cart-summary">
            <h3 style="color: #e5e5e5; margin-bottom: 15px;">📦 Récapitulatif de la commande</h3>
            <?php foreach ($cart as $item): ?>
                <div class="cart-item-payment">
                    <span style="color: #b3b3b3;"><?= htmlspecialchars($item['titre']) ?></span>
                    <span style="color: #e5e5e5; font-weight: bold;"><?= number_format($item['prix'], 2, ',', ' ') ?> €</span>
                </div>
            <?php endforeach; ?>
        </div>
        
        <form method="POST" action="payment_process_c.php" id="payment-form">
            <input type="hidden" name="cart" value='<?= htmlspecialchars($cart_json) ?>'>
            <input type="hidden" name="total" value="<?= $total ?>">
            
            <div class="form-group">
                <label style="color: #e5e5e5; margin-bottom: 8px; display: block;">Numéro de carte</label>
                <input type="text" name="carte_numero" class="card-input" 
                       placeholder="1234 5678 9012 3456" 
                       maxlength="19" 
                       required>
            </div>
            
            <div class="form-group">
                <label style="color: #e5e5e5; margin-bottom: 8px; display: block;">Nom sur la carte</label>
                <input type="text" name="carte_nom" class="card-input" 
                       placeholder="JEAN DUPONT" 
                       required>
            </div>
            
            <div class="card-row">
                <div class="form-group">
                    <label style="color: #e5e5e5; margin-bottom: 8px; display: block;">Date d'expiration</label>
                    <input type="text" name="carte_expiration" class="card-input" 
                           placeholder="MM/AA" 
                           maxlength="5" 
                           required>
                </div>
                
                <div class="form-group">
                    <label style="color: #e5e5e5; margin-bottom: 8px; display: block;">CVV</label>
                    <input type="text" name="carte_cvv" class="card-input" 
                           placeholder="123" 
                           maxlength="3" 
                           required>
                </div>
            </div>
            
            <!-- MODE TEST -->
            <div class="test-mode">
                <h3>⚠️ MODE TEST - Simulateur de paiement</h3>
                <label>
                    <input type="radio" name="test_result" value="ok" checked>
                    ✅ Simuler un paiement réussi
                </label>
                <label>
                    <input type="radio" name="test_result" value="error">
                    ❌ Simuler un échec de paiement
                </label>
            </div>
            
            <button type="submit" class="btn-pay">🔒 Payer <?= number_format($total, 2, ',', ' ') ?> €</button>
            <a href="catalogue_c.php" class="btn-cancel">Annuler et retourner au catalogue</a>
            
            <div class="secure-badge">
                🔒 Paiement 100% sécurisé et crypté
            </div>
        </form>
    </div>
    
    <script>
        // Formater automatiquement le numéro de carte
        document.querySelector('input[name="carte_numero"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
        
        // Formater la date d'expiration
        document.querySelector('input[name="carte_expiration"]').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
        
        // Accepter uniquement des chiffres pour le CVV
        document.querySelector('input[name="carte_cvv"]').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    </script>
</body>
</html>
