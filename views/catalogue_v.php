<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - SmartCulture</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-content">
        <div class="logo" onclick="window.location.reload()">
            <img src="../img3.png" style="height: 40px; cursor: pointer;">
        </div>
            
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
 <button type="submit">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;">
        <circle cx="11" cy="11" r="8"></circle>
        <path d="m21 21-4.35-4.35"></path>
    </svg>
    Rechercher
</button>            </form>
        </div>
        
        <div class="filter-buttons">
            <a href="catalogue_c.php" class="filter-btn <?= empty($type) && empty($search) ? 'active' : '' ?>">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;">
        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
    </svg>
    Tous
</a>
<a href="catalogue_c.php?type=DVD" class="filter-btn <?= ($type ?? '') === 'DVD' ? 'active' : '' ?>">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;">
        <circle cx="12" cy="12" r="10"></circle>
        <circle cx="12" cy="12" r="3"></circle>
    </svg>
    DVD
</a>
<a href="catalogue_c.php?type=Bluray" class="filter-btn <?= ($type ?? '') === 'Bluray' ? 'active' : '' ?>">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 6px;">
        <circle cx="12" cy="12" r="10"></circle>
        <circle cx="12" cy="12" r="3"></circle>
        <path d="M12 2v4m0 12v4M2 12h4m12 0h4"></path>
    </svg>
    Blu-ray
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
 <p class="product-date">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px;">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
        <line x1="16" y1="2" x2="16" y2="6"></line>
        <line x1="8" y1="2" x2="8" y2="6"></line>
        <line x1="3" y1="10" x2="21" y2="10"></line>
    </svg>
    Sortie : <?= htmlspecialchars($produit['date_sortie']) ?>
</p>                            
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
                            
                            <!-- <div class="product-actions">
                                <button class="btn btn-cart" 
                                        onclick='addToCart(<?= json_encode($produit) ?>)' 
                                        <?= ($produit['stock'] ?? 0) == 0 ? 'disabled' : '' ?>>
                                    🛒 Ajouter au panier
                                </button>
                            </div> -->
                            <div class="product-actions">
    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
        <!-- Boutons Admin -->
       <button class="btn btn-edit" onclick='editProduct(<?= json_encode($produit) ?>)' title="Modifier">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
    </svg>
</button>
         <button class="btn btn-delete" onclick="deleteProduct(<?= $produit['id'] ?>, '<?= $produit['type'] ?>')" title="Supprimer">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="3 6 5 6 21 6"></polyline>
        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
        <line x1="10" y1="11" x2="10" y2="17"></line>
        <line x1="14" y1="11" x2="14" y2="17"></line>
    </svg>
</button>
    <?php endif; ?>
    
    <!-- Bouton Panier (pour tous) -->
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

    <!-- Modal Modification Produit -->
<div id="edit-product-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
 <h2>
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle;">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
    </svg>
    Modifier le Produit
</h2>
            <button class="close-modal" onclick="closeModal('edit-product')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="edit-product-form" onsubmit="submitEditProduct(event)">
                <input type="hidden" id="edit-product-id" name="id">
                <input type="hidden" id="edit-product-type" name="type">
                
                <div class="form-group">
                    <label>Type de produit</label>
                    <input type="text" id="edit-type-display" disabled style="background: #f5f5f5;">
                </div>
                
                <div class="form-group">
                    <label for="edit-product-title">Titre *</label>
                    <input type="text" id="edit-product-title" name="titre" required>
                </div>
                
                <div class="form-group">
                    <label for="edit-product-date">Année de sortie *</label>
                    <input type="text" id="edit-product-date" name="date_sortie" required maxlength="4">
                </div>
                
                <div class="form-group">
                    <label for="edit-product-description">Description</label>
                    <textarea id="edit-product-description" name="description" rows="4"></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit-product-price">Prix (€) *</label>
                        <input type="number" id="edit-product-price" name="prix" step="0.01" min="0" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit-product-stock">Stock *</label>
                        <input type="number" id="edit-product-stock" name="stock" min="0" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('edit-product')">Annuler</button>
                    <button type="submit" class="btn-submit">✓ Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>
        <?php endif; ?>

<!-- Après la fermeture de </div> du container, AVANT le script JavaScript -->

<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
<!-- Bouton Flottant Admin -->
<button class="fab-add" onclick="openModal('add-product')" title="Ajouter un produit">
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="12" y1="5" x2="12" y2="19"></line>
        <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
</button>

<!-- Modal Ajout Produit -->
<div id="add-product-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>➕ Ajouter un Produit</h2>
            <button class="close-modal" onclick="closeModal('add-product')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="add-product-form" onsubmit="submitProduct(event)">
                <div class="form-group">
                    <label for="product-type">Type de produit *</label>
                    <select id="product-type" name="type" required>
                        <option value="">Sélectionner...</option>
                        <option value="DVD">💿 DVD</option>
                        <option value="Bluray">💎 Blu-ray</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="product-title">Titre *</label>
                    <input type="text" id="product-title" name="titre" required placeholder="Ex: Inception">
                </div>
                
                <div class="form-group">
                    <label for="product-date">Année de sortie *</label>
                    <input type="text" id="product-date" name="date_sortie" required placeholder="Ex: 2010" maxlength="4">
                </div>
                
                <div class="form-group">
                    <label for="product-description">Description</label>
                    <textarea id="product-description" name="description" rows="4" placeholder="Description du produit..."></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="product-price">Prix (€) *</label>
                        <input type="number" id="product-price" name="prix" step="0.01" min="0" required placeholder="19.99">
                    </div>
                    
                    <div class="form-group">
                        <label for="product-stock">Stock *</label>
                        <input type="number" id="product-stock" name="stock" min="0" required placeholder="10">
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn-cancel" onclick="closeModal('add-product')">Annuler</button>
                    <button type="submit" class="btn-submit">✓ Ajouter le produit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

    </div>
    <script src="../script.js"></script>
</body>
</html>