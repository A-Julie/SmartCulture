<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - SmartCulture</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #667eea;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .icon-btn {
            position: relative;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 20px;
        }

        .icon-btn:hover {
            background: #667eea;
            color: white;
            transform: scale(1.1);
        }

        .icon-btn.cart {
            background: #667eea;
            color: white;
        }

        .icon-btn.cart:hover {
            background: #5568d3;
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        .icon-btn.logout {
            background: #dc3545;
            color: white;
        }

        .icon-btn.logout:hover {
            background: #c82333;
        }

        /* Modal Panier */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            animation: fadeIn 0.3s;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: slideUp 0.3s;
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            padding: 20px;
            background: #667eea;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-modal {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .close-modal:hover {
            background: rgba(255,255,255,0.2);
        }

        .modal-body {
            padding: 20px;
            overflow-y: auto;
            flex: 1;
        }

        .cart-empty {
            text-align: center;
            padding: 50px 20px;
            color: #999;
        }

        .cart-empty-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .cart-items {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .cart-item {
            display: flex;
            gap: 15px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            align-items: center;
        }

        .cart-item-image {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .cart-item-type {
            font-size: 12px;
            color: #667eea;
            font-weight: 600;
        }

        .cart-item-price {
            font-size: 18px;
            font-weight: 700;
            color: #667eea;
        }

        .cart-item-remove {
            background: #dc3545;
            color: white;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .cart-item-remove:hover {
            background: #c82333;
        }

        .modal-footer {
            padding: 20px;
            background: #f8f9fa;
            border-top: 1px solid #ddd;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .cart-total-amount {
            color: #667eea;
        }

        .btn-checkout {
            width: 100%;
            padding: 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-checkout:hover {
            background: #218838;
        }

        .btn-checkout:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Modal Profil */
        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .profile-field {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .profile-label {
            font-size: 12px;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .profile-value {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        /* Filtres */
        .filters {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box form {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .search-box button {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .search-box button:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 12px 25px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            display: inline-block;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Catalogue */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .products-header {
            color: white;
            margin-bottom: 30px;
        }

        .products-header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .products-count {
            font-size: 18px;
            opacity: 0.9;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .product-image {
            width: 100%;
            height: 350px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 80px;
        }

        .product-info {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-type {
            display: inline-block;
            padding: 5px 12px;
            background: #667eea;
            color: white;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 10px;
            align-self: flex-start;
        }

        .product-type.bluray {
            background: #764ba2;
        }

        .product-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .product-date {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .product-description {
            color: #777;
            font-size: 13px;
            line-height: 1.5;
            margin-bottom: 15px;
            flex: 1;
        }

        .product-price {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .product-stock {
            font-size: 13px;
            color: #28a745;
            margin-bottom: 15px;
        }

        .product-stock.low {
            color: #ffc107;
        }

        .product-stock.out {
            color: #dc3545;
        }

        .product-actions {
            margin-top: auto;
            display: flex;
            gap: 10px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .btn-cart {
            background: #667eea;
            color: white;
        }

        .btn-cart:hover {
            background: #5568d3;
        }

        .btn-cart:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .no-products {
            text-align: center;
            color: white;
            font-size: 20px;
            padding: 50px;
            background: rgba(255,255,255,0.1);
            border-radius: 15px;
        }

        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 20px;
            }

            .product-image {
                height: 250px;
                font-size: 60px;
            }

            .products-header h1 {
                font-size: 28px;
            }
            
            .header-actions {
                gap: 10px;
            }
            
            .icon-btn {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="logo" onclick="window.location.reload()">🎬 SmartCulture</div>              
<div class="header-actions">
    <!-- Bouton Panier -->
    <button class="icon-btn cart" onclick="openModal('cart')" title="Panier">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span class="cart-badge" id="cart-count">0</span>
    </button>
    
    <!-- Bouton Profil -->
    <button class="icon-btn" onclick="openModal('profile')" title="Mon profil">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
        </svg>
    </button>
    
    <!-- Bouton Déconnexion -->
    <button class="icon-btn logout" onclick="logout()" title="Déconnexion">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
        </svg>
    </button>
</div>
        </div>
    </div>

    <!-- Modal Panier -->
    <div id="cart-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>🛒 Mon Panier</h2>
                <button class="close-modal" onclick="closeModal('cart')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="cart-content">
                    <div class="cart-empty">
                        <div class="cart-empty-icon">🛒</div>
                        <p>Votre panier est vide</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer" id="cart-footer" style="display: none;">
                <div class="cart-total">
                    <span>Total :</span>
                    <span class="cart-total-amount" id="cart-total">0,00 €</span>
                </div>
                <button class="btn-checkout" onclick="checkout()">
                    💳 Passer la commande
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Profil -->
    <div id="profile-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>👤 Mon Profil</h2>
                <button class="close-modal" onclick="closeModal('profile')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="profile-info">
                    <div class="profile-field">
                        <div class="profile-label">Prénom</div>
                        <div class="profile-value"><?= htmlspecialchars($_SESSION['user_prenom']) ?></div>
                    </div>
                    <div class="profile-field">
                        <div class="profile-label">Nom</div>
                        <div class="profile-value"><?= htmlspecialchars($_SESSION['user_nom']) ?></div>
                    </div>
                    <div class="profile-field">
                        <div class="profile-label">Email</div>
                        <div class="profile-value"><?= htmlspecialchars($_SESSION['user_email']) ?></div>
                    </div>
                    <div class="profile-field">
                        <div class="profile-label">Membre depuis</div>
                        <div class="profile-value"><?= date('d/m/Y') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters">
        <div class="search-box">
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Rechercher un film..." value="<?= htmlspecialchars($search ?? '') ?>">
                <button type="submit">🔍 Rechercher</button>
            </form>
        </div>
        
        <div class="filter-buttons">
            <a href="catalogue_c.php" class="filter-btn <?= empty($type) && empty($search) ? 'active' : '' ?>">
                📚 Tous
            </a>
            <a href="catalogue_c.php?type=DVD" class="filter-btn <?= ($type ?? '') === 'DVD' ? 'active' : '' ?>">
                💿 DVD
            </a>
            <a href="catalogue_c.php?type=Bluray" class="filter-btn <?= ($type ?? '') === 'Bluray' ? 'active' : '' ?>">
                💎 Blu-ray
            </a>
        </div>
    </div>

    <!-- Catalogue -->
    <div class="container">
        <div class="products-header">
            <h1><?= $titre_page ?? 'Catalogue' ?></h1>
            <p class="products-count"><?= count($produits ?? []) ?> produit(s) trouvé(s)</p>
        </div>

        <?php if (empty($produits)): ?>
            <div class="no-products">
                <p>😔 Aucun produit trouvé</p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($produits as $produit): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <?= $produit['type'] === 'DVD' ? '💿' : '💎' ?>
                        </div>
                        <div class="product-info">
                            <span class="product-type <?= strtolower($produit['type']) ?>">
                                <?= htmlspecialchars($produit['type']) ?>
                            </span>
                            <h3 class="product-title"><?= htmlspecialchars($produit['titre']) ?></h3>
                            <p class="product-date">📅 Sortie : <?= htmlspecialchars($produit['date_sortie']) ?></p>
                            
                            <?php if (!empty($produit['description'])): ?>
                                <p class="product-description"><?= htmlspecialchars(substr($produit['description'], 0, 100)) ?>...</p>
                            <?php endif; ?>
                            
                            <?php if (isset($produit['prix'])): ?>
                                <div class="product-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</div>
                            <?php endif; ?>
                            
                            <?php if (isset($produit['stock'])): ?>
                                <div class="product-stock <?= $produit['stock'] == 0 ? 'out' : ($produit['stock'] < 5 ? 'low' : '') ?>">
                                    <?= $produit['stock'] > 0 ? "📦 En stock ({$produit['stock']})" : "❌ Rupture de stock" ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="product-actions">
                                <button class="btn btn-cart" 
                                        onclick='addToCart(<?= json_encode($produit) ?>)' 
                                        <?= ($produit['stock'] ?? 0) == 0 ? 'disabled' : '' ?>>
                                    🛒 Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        // Panier (stocké dans localStorage)
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        // Mettre à jour le compteur du panier au chargement
        updateCartCount();
        
        function addToCart(product) {
            // Vérifier si le produit existe déjà
            const existingItem = cart.find(item => item.id === product.id && item.type === product.type);
            
            if (existingItem) {
                alert('Ce produit est déjà dans votre panier !');
                return;
            }
            
            cart.push(product);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            
            // Animation de feedback
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '✓ Ajouté !';
            btn.style.background = '#28a745';
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.style.background = '';
            }, 1500);
        }
        
        function removeFromCart(index) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            displayCart();
        }
        
        function updateCartCount() {
            document.getElementById('cart-count').textContent = cart.length;
        }
        
        function displayCart() {
            const cartContent = document.getElementById('cart-content');
            const cartFooter = document.getElementById('cart-footer');
            
            if (cart.length === 0) {
                cartContent.innerHTML = `
                    <div class="cart-empty">
                        <div class="cart-empty-icon">🛒</div>
                        <p>Votre panier est vide</p>
                    </div>
                `;
                cartFooter.style.display = 'none';
                return;
            }
            
            let total = 0;
            let html = '<div class="cart-items">';
            
            cart.forEach((item, index) => {
                const price = parseFloat(item.prix) || 0;
                total += price;
                
                html += `
                    <div class="cart-item">
                        <div class="cart-item-image">
                            ${item.type === 'DVD' ? '💿' : '💎'}
                        </div>
                        <div class="cart-item-info">
                            <div class="cart-item-title">${item.titre}</div>
                            <div class="cart-item-type">${item.type}</div>
                        </div>
                        <div class="cart-item-price">${price.toFixed(2).replace('.', ',')} €</div>
                        <button class="cart-item-remove" onclick="removeFromCart(${index})" title="Retirer">
                            ×
                        </button>
                    </div>
                `;
            });
            
            html += '</div>';
            cartContent.innerHTML = html;
            
            document.getElementById('cart-total').textContent = total.toFixed(2).replace('.', ',') + ' €';
            cartFooter.style.display = 'block';
        }
        
        function openModal(type) {
            if (type === 'cart') {
                displayCart();
                document.getElementById('cart-modal').classList.add('active');
            } else if (type === 'profile') {
                document.getElementById('profile-modal').classList.add('active');
            }
        }
        
        function closeModal(type) {
            if (type === 'cart') {
                document.getElementById('cart-modal').classList.remove('active');
            } else if (type === 'profile') {
                document.getElementById('profile-modal').classList.remove('active');
            }
        }
        
        // Fermer la modal en cliquant à l'extérieur
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
        
        function logout() {
            if (confirm('Voulez-vous vraiment vous déconnecter ?')) {
                window.location.href = '../controllers/authentication_c.php?action=logout';
            }
        }
        
        function checkout() {
            if (cart.length === 0) return;
            
            alert('Redirection vers la page de paiement...\n\nTotal : ' + document.getElementById('cart-total').textContent);
            // TODO: Implémenter la page de commande
        }
    </script>
</body>
</html>