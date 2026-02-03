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
    btn.innerHTML = 'Ajouté !';
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
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = cart.length;
    }
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
    } else if (type === 'add-product') {
        document.getElementById('add-product-modal').classList.add('active');
    } else if (type === 'edit-product') {
        document.getElementById('edit-product-modal').classList.add('active');
    }
}

function closeModal(type) {
    if (type === 'cart') {
        document.getElementById('cart-modal').classList.remove('active');
    } else if (type === 'profile') {
        document.getElementById('profile-modal').classList.remove('active');
    } else if (type === 'add-product') {
        document.getElementById('add-product-modal').classList.remove('active');
    } else if (type === 'edit-product') {
        document.getElementById('edit-product-modal').classList.remove('active');
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

//  NOUVELLE FONCTION CHECKOUT 
function checkout() {
    if (cart.length === 0) {
        alert('Votre panier est vide !');
        return;
    }
    
    // Créer un formulaire pour envoyer le panier en POST
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '../controllers/payment_c.php';
    
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'cart';
    input.value = JSON.stringify(cart);
    
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();
}

function submitProduct(event) {
    event.preventDefault();
    
    const form = document.getElementById('add-product-form');
    const formData = new FormData(form);
    
    // Désactiver le bouton pendant l'envoi
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Ajout en cours...';
    
    fetch('../controllers/produit_add_c.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal('add-product');
            form.reset();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

// Fonction pour modifier un produit
function editProduct(product) {
    document.getElementById('edit-product-id').value = product.id;
    document.getElementById('edit-product-type').value = product.type;
    document.getElementById('edit-type-display').value = product.type === 'DVD' ? 'DVD' : 'Blu-ray';
    document.getElementById('edit-product-title').value = product.titre;
    document.getElementById('edit-product-date').value = product.date_sortie;
    document.getElementById('edit-product-description').value = product.description || '';
    document.getElementById('edit-product-price').value = product.prix || 0;
    document.getElementById('edit-product-stock').value = product.stock || 0;
    
    openModal('edit-product');
}

// Fonction pour soumettre la modification
function submitEditProduct(event) {
    event.preventDefault();
    
    const form = document.getElementById('edit-product-form');
    const formData = new FormData(form);
    formData.append('action', 'update');
    
    const submitBtn = form.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = 'Modification en cours...';
    
    fetch('../controllers/produit_manage_c.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeModal('edit-product');
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
}

// Fonction pour supprimer un produit
function deleteProduct(id, type) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce produit ?\n\nCette action est irréversible.')) {
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', id);
    formData.append('type', type);
    
    fetch('../controllers/produit_manage_c.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert(' Une erreur est survenue');
    });
};