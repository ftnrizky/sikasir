// receipt-system.js - Receipt System Functions

// Print receipt
function printReceipt() {
    if (window.orderItems.length === 0) {
        showMessage("No items to print!", "warning");
        return;
    }

    generateReceiptContent();
    const printModal = document.getElementById("printModal");
    if (printModal) {
        printModal.classList.remove("hidden");
    }
}

// Generate receipt content
function generateReceiptContent() {
    const now = new Date();
    const dateTime = now.toLocaleString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    const discountPercent =
        parseFloat(document.getElementById("discount-input")?.value) || 0;
    const taxPercent =
        parseFloat(document.getElementById("tax-input")?.value) || 0;
    const subtotal = window.orderItems.reduce(
        (sum, item) => sum + item.totalPrice,
        0
    );
    const discountAmount = (subtotal * discountPercent) / 100;
    const subtotalAfterDiscount = subtotal - discountAmount;
    const taxAmount = (subtotalAfterDiscount * taxPercent) / 100;
    const grandTotal = subtotalAfterDiscount + taxAmount;

    const cashierName =
        document.getElementById("cashier-name")?.textContent ||
        "Unknown Cashier";

    let receiptHTML = `
        <div class="text-center mb-4">
            <h2 class="text-lg font-bold">Ali Akbar Coffee</h2>
            <p class="text-xs">Jl. Raya Malabarar</p>
            <p class="text-xs">Telp: (021) 123-4567</p>
            <p class="text-xs">Email: aliakbaar@gmail.com</p>
            <p class="text-xs border-b border-dashed pb-2 mb-2">================================</p>
            <p class="text-xs">Tanggal: ${dateTime}</p>
            <p class="text-xs">Kasir: ${escapeHtml(cashierName)}</p>
            <p class="text-xs">Order #: ${generateOrderNumber()}</p>
            <p class="text-xs border-b border-dashed pb-2 mb-2">================================</p>
        </div>
        
        <div class="mb-4">
    `;

    window.orderItems.forEach((item, index) => {
        receiptHTML += `
            <div class="mb-3">
                <div class="flex justify-between text-xs font-semibold">
                    <span>${index + 1}. ${escapeHtml(item.productName)}</span>
                    <span>x${item.amount}</span>
                </div>
                <div class="ml-2 text-xs text-gray-600">
                    <div class="grid grid-cols-2 gap-2 mb-1">
                        <div>Size: ${escapeHtml(item.customizations.size)}</div>
                        <div>Sugar: ${escapeHtml(
                            item.customizations.sugar
                        )}</div>
                        <div>Ice: ${escapeHtml(item.customizations.ice)}</div>
                        <div>Topping: ${escapeHtml(
                            item.customizations.topping
                        )}</div>
                    </div>
                    <div class="flex justify-between mt-1 font-medium">
                        <span>@ Rp ${item.itemPrice.toLocaleString(
                            "id-ID"
                        )}</span>
                        <span>Rp ${item.totalPrice.toLocaleString(
                            "id-ID"
                        )}</span>
                    </div>
                </div>
            </div>
        `;
    });

    receiptHTML += `
        </div>
        
        <div class="border-t border-dashed pt-2 mb-4 text-xs">
            <div class="flex justify-between mb-1">
                <span>Subtotal (${window.orderItems.length} items):</span>
                <span>Rp ${subtotal.toLocaleString("id-ID")}</span>
            </div>
    `;

    if (discountPercent > 0) {
        receiptHTML += `
            <div class="flex justify-between mb-1 text-green-600">
                <span>Diskon (${discountPercent}%):</span>
                <span>-Rp ${discountAmount.toLocaleString("id-ID")}</span>
            </div>
        `;
    }

    if (taxPercent > 0) {
        receiptHTML += `
            <div class="flex justify-between mb-1 text-red-600">
                <span>Pajak (${taxPercent}%):</span>
                <span>Rp ${taxAmount.toLocaleString("id-ID")}</span>
            </div>
        `;
    }

    receiptHTML += `
            <div class="flex justify-between font-bold border-t mt-2 pt-2 text-sm">
                <span>TOTAL BAYAR:</span>
                <span>Rp ${grandTotal.toLocaleString("id-ID")}</span>
            </div>
        </div>
        
        <div class="text-center text-xs border-t border-dashed pt-4">
            <p class="mb-2 font-medium">Terima kasih atas kunjungan Anda!</p>
            <p class="mb-2">Selamat menikmati pesanan Anda</p>
            <p class="mb-2">Jam Operasional: 14:00 - 23:00</p>
            <p class="mb-2">Kritik dan saran: aliakbar@gmail.com</p>
            <p class="text-xs border-t border-dashed pt-2 mt-2">================================</p>
            <p class="mt-2 font-medium">** Struk ini adalah bukti pembayaran yang sah **</p>
            <p class="mt-1">Simpan struk ini untuk keperluan garansi</p>
        </div>
    `;

    const receiptContent = document.getElementById("receipt-content");
    if (receiptContent) {
        receiptContent.innerHTML = receiptHTML;
    }
}

// Generate receipt from specific order data
function generateReceiptFromOrderData(orderData) {
    const { items, totals, paymentMethod, totalAmount, timestamp } = orderData;

    const dateTime = timestamp.toLocaleString("id-ID", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });

    const subtotal = totals.subtotal;
    const discountAmount = (subtotal * totals.discount) / 100;
    const subtotalAfterDiscount = subtotal - discountAmount;
    const taxAmount = (subtotalAfterDiscount * totals.tax) / 100;
    const grandTotal = subtotalAfterDiscount + taxAmount;

    const cashierName =
        document.getElementById("cashier-name")?.textContent ||
        "Unknown Cashier";
    const paymentMethodText = paymentMethod === "qris" ? "QRIS" : "TUNAI";

    let receiptHTML = `
        <div class="text-center mb-4">
            <h2 class="text-lg font-bold">Ali Akbar Coffee</h2>
            <p class="text-xs">Jl. Raya Malabarar</p>
            <p class="text-xs">Telp: (021) 123-4567</p>
            <p class="text-xs">Email: aliakbaar@gmail.com</p>
            <p class="text-xs border-b border-dashed pb-2 mb-2">================================</p>
            <p class="text-xs">Tanggal: ${dateTime}</p>
            <p class="text-xs">Kasir: ${escapeHtml(cashierName)}</p>
            <p class="text-xs">Order #: ${generateOrderNumber()}</p>
            <p class="text-xs">Pembayaran: ${paymentMethodText}</p>
            <p class="text-xs border-b border-dashed pb-2 mb-2">================================</p>
        </div>
        
        <div class="mb-4">
    `;

    items.forEach((item, index) => {
        receiptHTML += `
            <div class="mb-3">
                <div class="flex justify-between text-xs font-semibold">
                    <span>${index + 1}. ${escapeHtml(item.productName)}</span>
                    <span>x${item.amount}</span>
                </div>
                <div class="ml-2 text-xs text-gray-600">
                    <div class="grid grid-cols-2 gap-2 mb-1">
                        <div>Size: ${escapeHtml(item.customizations.size)}</div>
                        <div>Sugar: ${escapeHtml(
                            item.customizations.sugar
                        )}</div>
                        <div>Ice: ${escapeHtml(item.customizations.ice)}</div>
                        <div>Topping: ${escapeHtml(
                            item.customizations.topping
                        )}</div>
                    </div>
                    <div class="flex justify-between mt-1 font-medium">
                        <span>@ Rp ${item.itemPrice.toLocaleString(
                            "id-ID"
                        )}</span>
                        <span>Rp ${item.totalPrice.toLocaleString(
                            "id-ID"
                        )}</span>
                    </div>
                </div>
            </div>
        `;
    });

    receiptHTML += `
        </div>
        
        <div class="border-t border-dashed pt-2 mb-4 text-xs">
            <div class="flex justify-between mb-1">
                <span>Subtotal (${items.length} items):</span>
                <span>Rp ${subtotal.toLocaleString("id-ID")}</span>
            </div>
    `;

    if (totals.discount > 0) {
        receiptHTML += `
            <div class="flex justify-between mb-1 text-green-600">
                <span>Diskon (${totals.discount}%):</span>
                <span>-Rp ${discountAmount.toLocaleString("id-ID")}</span>
            </div>
        `;
    }

    if (totals.tax > 0) {
        receiptHTML += `
            <div class="flex justify-between mb-1 text-red-600">
                <span>Pajak (${totals.tax}%):</span>
                <span>Rp ${taxAmount.toLocaleString("id-ID")}</span>
            </div>
        `;
    }

    receiptHTML += `
            <div class="flex justify-between font-bold border-t mt-2 pt-2 text-sm">
                <span>TOTAL BAYAR:</span>
                <span>Rp ${grandTotal.toLocaleString("id-ID")}</span>
            </div>
        </div>
        
        <div class="text-center text-xs border-t border-dashed pt-4">
            <p class="mb-2 font-medium">Terima kasih atas kunjungan Anda!</p>
            <p class="mb-2">Selamat menikmati pesanan Anda</p>
            <p class="mb-2">Jam Operasional: 14:00 - 23:00</p>
            <p class="mb-2">Kritik dan saran: aliakbar@gmail.com</p>
            <p class="text-xs border-t border-dashed pt-2 mt-2">================================</p>
            <p class="mt-2 font-medium">** Struk ini adalah bukti pembayaran yang sah **</p>
            <p class="mt-1">Simpan struk ini untuk keperluan garansi</p>
            <p class="mt-2 text-xs">*** PEMBAYARAN BERHASIL ***</p>
        </div>
    `;

    // Store in a temporary element for printing
    window.tempReceiptContent = receiptHTML;
}

// Close print modal
function closePrintModal() {
    const printModal = document.getElementById("printModal");
    if (printModal) {
        printModal.classList.add("hidden");
    }
}

// Actual print function
function actualPrint() {
    const receiptContent = document.getElementById("receipt-content");
    if (!receiptContent) {
        showMessage("Receipt content not found!", "error");
        return;
    }

    const content = receiptContent.innerHTML;
    printReceiptContent(content);

    // Close modal after print
    setTimeout(() => {
        closePrintModal();
        showMessage("Receipt sent to printer!", "success");
    }, 1000);
}

// Print receipt directly without modal
function printReceiptDirectly() {
    if (!window.tempReceiptContent) {
        showMessage("No receipt content to print!", "error");
        return;
    }

    printReceiptContent(window.tempReceiptContent);

    // Clean up
    delete window.tempReceiptContent;
    showMessage("Receipt printed successfully!", "success");
}

// Core print function
function printReceiptContent(content) {
    const printWindow = window.open("", "", "width=400,height=700");

    if (!printWindow) {
        showMessage("Please allow popups to print receipt", "warning");
        return;
    }

    printWindow.document.write(`
        <html>
            <head>
                <title>Receipt - Ali Akbar Coffee</title>
                <style>
                    @media print {
                        @page {
                            size: 80mm auto;
                            margin: 0;
                        }
                    }
                    
                    body { 
                        font-family: 'Courier New', monospace; 
                        font-size: 12px; 
                        margin: 0; 
                        padding: 10px; 
                        width: 300px;
                        line-height: 1.3;
                    }
                    
                    .text-center { text-align: center; }
                    .text-left { text-align: left; }
                    .text-right { text-align: right; }
                    .text-xs { font-size: 10px; }
                    .text-sm { font-size: 11px; }
                    .text-lg { font-size: 14px; }
                    .font-bold { font-weight: bold; }
                    .font-medium { font-weight: 500; }
                    .font-semibold { font-weight: 600; }
                    
                    .mb-1 { margin-bottom: 4px; }
                    .mb-2 { margin-bottom: 8px; }
                    .mb-3 { margin-bottom: 12px; }
                    .mb-4 { margin-bottom: 16px; }
                    .mt-1 { margin-top: 4px; }
                    .mt-2 { margin-top: 8px; }
                    .ml-2 { margin-left: 8px; }
                    .pt-2 { padding-top: 8px; }
                    .pt-4 { padding-top: 16px; }
                    .pb-2 { padding-bottom: 8px; }
                    
                    .border-t { border-top: 1px solid #000; }
                    .border-b { border-bottom: 1px solid #000; }
                    .border-dashed { border-style: dashed; }
                    
                    .flex { display: flex; }
                    .justify-between { justify-content: space-between; }
                    .grid { display: grid; }
                    .grid-cols-2 { grid-template-columns: repeat(2, 1fr); }
                    .gap-2 { gap: 8px; }
                    
                    .text-gray-600 { color: #4b5563; }
                    .text-green-600 { color: #059669; }
                    .text-red-600 { color: #dc2626; }
                    
                    /* Print-specific styles */
                    @media print {
                        body {
                            width: 70mm;
                            font-size: 11px;
                            padding: 5px;
                        }
                        .text-xs { font-size: 9px; }
                        .text-sm { font-size: 10px; }
                    }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                ${content}
            </body>
        </html>
    `);

    printWindow.document.close();
}

// Print receipt for completed order (can be called after payment)
function printOrderReceipt(orderData = null) {
    if (!orderData && window.orderItems.length === 0) {
        showMessage("No order data to print!", "warning");
        return;
    }

    // Use provided order data or current order
    const dataToUse = orderData || {
        items: window.orderItems,
        totals: {
            subtotal: window.orderItems.reduce(
                (sum, item) => sum + item.totalPrice,
                0
            ),
            discount:
                parseFloat(document.getElementById("discount-input")?.value) ||
                0,
            tax: parseFloat(document.getElementById("tax-input")?.value) || 0,
        },
        paymentMethod: "cash",
        totalAmount: calculateGrandTotal(),
        timestamp: new Date(),
    };

    generateReceiptFromOrderData(dataToUse);
    printReceiptDirectly();
}

// Export functions for global access
window.printReceipt = printReceipt;
window.closePrintModal = closePrintModal;
window.actualPrint = actualPrint;
window.generateReceiptContent = generateReceiptContent;
window.generateReceiptFromOrderData = generateReceiptFromOrderData;
window.printOrderReceipt = printOrderReceipt;
window.printReceiptDirectly = printReceiptDirectly;
