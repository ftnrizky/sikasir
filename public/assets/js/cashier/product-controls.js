// product-controls.js - Product Control Functions

// Amount control functions
function decrementAmount(button) {
    const input = button.parentElement.querySelector('input[name="amount"]');
    if (!input) return;

    const currentValue = parseInt(input.value) || 1;
    if (currentValue > 1) {
        input.value = currentValue - 1;

        // Trigger price update if in detailed view
        if (window.currentViewMode === "detailed") {
            updateDetailedPrice(input);
        }
    }
}

function incrementAmount(button) {
    const input = button.parentElement.querySelector('input[name="amount"]');
    if (!input) return;

    const currentValue = parseInt(input.value) || 1;
    input.value = currentValue + 1;

    // Trigger price update if in detailed view
    if (window.currentViewMode === "detailed") {
        updateDetailedPrice(input);
    }
}

// Price update functions
function updateDetailedPrice(element) {
    const form = element.closest("form");
    if (!form) return;

    const productId = form.getAttribute("data-product-id");
    const basePrice = parseInt(form.getAttribute("data-base-price")) || 0;

    // Get current selections
    const amount =
        parseInt(form.querySelector('input[name="amount"]')?.value) || 1;
    const sizeInput = form.querySelector(
        `input[name="size_${productId}"]:checked`
    );
    const toppingInput = form.querySelector(
        `input[name="topping_${productId}"]:checked`
    );

    let totalPrice = basePrice;

    // Add size modifier
    if (sizeInput && sizeInput.getAttribute("data-price-modifier")) {
        totalPrice +=
            parseInt(sizeInput.getAttribute("data-price-modifier")) || 0;
    }

    // Add topping modifier
    if (toppingInput && toppingInput.getAttribute("data-price-modifier")) {
        totalPrice +=
            parseInt(toppingInput.getAttribute("data-price-modifier")) || 0;
    }

    // Multiply by amount
    totalPrice *= amount;

    // Update display
    const priceDisplay = document.getElementById(`total-price-${productId}`);
    if (priceDisplay) {
        priceDisplay.textContent = `Rp ${totalPrice.toLocaleString("id-ID")}`;
    }

    // Update form data
    form.setAttribute("data-item-price", totalPrice);

    console.log(
        `Price updated for product ${productId}: Rp ${totalPrice.toLocaleString(
            "id-ID"
        )}`
    );
}

// Add to order function
function addToOrder(event) {
    event.preventDefault();

    const form = event.target;
    const productId = form.getAttribute("data-product-id");
    const productName = form.getAttribute("data-product-name");
    const costPrice = parseInt(form.getAttribute("data-cost-price")) || 0;
    const amount =
        parseInt(form.querySelector('input[name="amount"]')?.value) || 1;

    if (!productId || !productName) {
        showMessage("Product information missing!", "error");
        return;
    }

    // Get customizations
    let customizations = {
        size: "M",
        sugar: "50%",
        ice: "50%",
        topping: "No Topping",
    };

    // For detailed view, get all selections
    if (window.currentViewMode === "detailed") {
        const sizeInput = form.querySelector(
            `input[name="size_${productId}"]:checked`
        );
        const sugarInput = form.querySelector(
            `input[name="sugar_${productId}"]:checked`
        );
        const iceInput = form.querySelector(
            `input[name="ice_${productId}"]:checked`
        );
        const toppingInput = form.querySelector(
            `input[name="topping_${productId}"]:checked`
        );

        if (sizeInput) customizations.size = sizeInput.value;
        if (sugarInput) customizations.sugar = sugarInput.value + "%";
        if (iceInput) customizations.ice = iceInput.value + "%";
        if (toppingInput) customizations.topping = toppingInput.value;
    }

    // Calculate item price
    const basePrice = parseInt(form.getAttribute("data-base-price")) || 0;
    let itemPrice = basePrice;

    // Add size modifier
    if (customizations.size === "L") {
        itemPrice += 3000;
    }

    // Add topping modifier
    if (customizations.topping === "Susu Oat") {
        itemPrice += 5000;
    } else if (customizations.topping === "Espresso") {
        itemPrice += 4000;
    }

    const totalPrice = itemPrice * amount;

    // Create order item
    const orderItem = {
        id: window.orderCounter++,
        productId: productId,
        productName: productName,
        amount: amount,
        itemPrice: itemPrice,
        totalPrice: totalPrice,
        costPrice: costPrice,
        totalCostPrice: costPrice * amount,
        customizations: customizations,
    };

    // Add to order
    window.orderItems.push(orderItem);

    // Update display
    updateOrderDisplay();
    updateTotals();

    // Reset form to default values
    resetForm(form);

    // Show success message
    showMessage(`${productName} added to order!`, "success");

    console.log("Item added to order:", orderItem);
}

// Reset form to default state
function resetForm(form) {
    if (!form) return;

    // Reset amount
    const amountInput = form.querySelector('input[name="amount"]');
    if (amountInput) {
        amountInput.value = "1";
    }

    // Reset to default selections in detailed view
    if (window.currentViewMode === "detailed") {
        const productId = form.getAttribute("data-product-id");

        // Reset size to M
        const sizeM = form.querySelector(
            `input[name="size_${productId}"][value="M"]`
        );
        if (sizeM) sizeM.checked = true;

        // Reset sugar to 50%
        const sugar50 = form.querySelector(
            `input[name="sugar_${productId}"][value="50"]`
        );
        if (sugar50) sugar50.checked = true;

        // Reset ice to 50%
        const ice50 = form.querySelector(
            `input[name="ice_${productId}"][value="50"]`
        );
        if (ice50) ice50.checked = true;

        // Reset topping to No Topping
        const noTopping = form.querySelector(
            `input[name="topping_${productId}"][value="No Topping"]`
        );
        if (noTopping) noTopping.checked = true;

        // Update price display
        updateDetailedPrice(amountInput);
    }
}

// Export functions for global access
window.decrementAmount = decrementAmount;
window.incrementAmount = incrementAmount;
window.updateDetailedPrice = updateDetailedPrice;
window.addToOrder = addToOrder;

// Legacy compatibility
window.updatePrice = updateDetailedPrice;
// Show message function
function showMessage(message, type = "info") {
    const messageContainer = document.getElementById("message-container");
    if (!messageContainer) return;

    const messageElement = document.createElement("div");
    messageElement.className = `alert alert-${type}`;
    messageElement.textContent = message;

    // Clear previous messages
    messageContainer.innerHTML = "";
    messageContainer.appendChild(messageElement);

    // Auto-hide after 3 seconds
    setTimeout(() => {
        messageContainer.removeChild(messageElement);
    }, 3000);
}