/* ----- NAVIGATION BAR FUNCTION ----- */
function myMenuFunction() {
    var menuBtn = document.getElementById("myNavMenu");

    if (menuBtn.className === "nav-menu") {
        menuBtn.className += " responsive";
    } else {
        menuBtn.className = "nav-menu";
    }
}

/* ----- ADD SHADOW ON NAVIGATION BAR WHILE SCROLLING ----- */
window.onscroll = function () { headerShadow() };

function headerShadow() {
    const navHeader = document.getElementById("header");

    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {

        navHeader.style.boxShadow = "0 1px 6px rgba(0, 0, 0, 0.1)";
        navHeader.style.height = "70px";
        navHeader.style.lineHeight = "70px";

    } else {

        navHeader.style.boxShadow = "none";
        navHeader.style.height = "90px";
        navHeader.style.lineHeight = "90px";

    }
}


/* ----- TYPING EFFECT ----- */
var typingEffect = new Typed(".typedText", {
    strings: [" Chekku Ennai "],
    loop: true,
    typeSpeed: 100,
    backSpeed: 80,
    backDelay: 2000
})


/* ----- ## -- SCROLL REVEAL ANIMATION -- ## ----- */
const sr = ScrollReveal({
    origin: 'top',
    distance: '80px',
    duration: 2000,
    reset: true
})

/* -- HOME -- */
sr.reveal('.featured-text-card', {})
sr.reveal('.featured-name', { delay: 100 })
sr.reveal('.featured-text-info', { delay: 200 })
sr.reveal('.featured-text-btn', { delay: 200 })
sr.reveal('.social_icons', { delay: 200 })
sr.reveal('.featured-image', { delay: 300 })


/* -- PROJECT BOX -- */
sr.reveal('.portfolio-content', { interval: 200 })

/* -- HEADINGS -- */
sr.reveal('.top-header', {})

/* ----- ## -- SCROLL REVEAL LEFT_RIGHT ANIMATION -- ## ----- */

/* -- ABOUT INFO & CONTACT INFO -- */
const srLeft = ScrollReveal({
    origin: 'left',
    distance: '80px',
    duration: 2000,
    reset: true
})

srLeft.reveal('.about-info', { delay: 100 })
srLeft.reveal('.contact-info', { delay: 100 })

/* -- ABOUT SKILLS & FORM BOX -- */
const srRight = ScrollReveal({
    origin: 'right',
    distance: '80px',
    duration: 2000,
    reset: true
})

srRight.reveal('.skills-box', { delay: 100 })
srRight.reveal('.form-control', { delay: 100 })



/* ----- CHANGE ACTIVE LINK ----- */

const sections = document.querySelectorAll('section[id]')

function scrollActive() {
    const scrollY = window.scrollY;

    sections.forEach(current => {
        const sectionHeight = current.offsetHeight,
            sectionTop = current.offsetTop - 50,
            sectionId = current.getAttribute('id')

        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {

            document.querySelector('.nav-menu a[href*=' + sectionId + ']').classList.add('active-link')

        } else {

            document.querySelector('.nav-menu a[href*=' + sectionId + ']').classList.remove('active-link')

        }
    })
}

window.addEventListener('scroll', scrollActive)

/* ----- form LINK ----- */

document.getElementById
    ('contact-form').addEventListener
    ('submit', function (event) {
        event.preventDefault();
        var data = new FormData(event.
            target);
        fetch("https://formspree.io/f/xbjnabjr", {
            method: 'POST',
            body: data,
        }).then(response => {
            if (response.ok) {
                alert('Success');
            } else {
                alert('Error');
            }
        });
        document.getElementById
            ('contact-form').reset();
    });

/* ----- ADD TO CART FUNCTIONALITY ----- */
let cart = [];
let total = 0;
let currentCheckout = null;

function addToCart(name, price) {
    cart.push({ name, price });
    total += price;
    updateCart();
    showNotification(`✅ ${name} added to cart!`);
}

function removeFromCart(itemName) {
    const index = cart.findIndex(item => item.name === itemName);
    if (index > -1) {
        total -= cart[index].price;
        cart.splice(index, 1);
        updateCart();
        showNotification(`❌ ${itemName} removed from cart`);
    }
}

function updateCart() {
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = '';

    if (cart.length === 0) {
        cartItems.innerHTML = `<div class="cart-empty">🛒 Your cart is empty!</div>`;
        updateCartBadge();
        return;
    }

    // Group items by name
    const itemMap = {};
    cart.forEach(item => {
        if (itemMap[item.name]) {
            itemMap[item.name].quantity += 1;
        } else {
            itemMap[item.name] = { price: item.price, quantity: 1 };
        }
    });

    for (const [name, details] of Object.entries(itemMap)) {
        const itemDiv = document.createElement('div');
        itemDiv.className = 'cart-item';
        itemDiv.innerHTML = `
            <div style="flex: 1;">
                <span style="font-weight: 600; color: #2d2d2d;">${name}</span>
                <div style="font-size: 12px; color: #666; margin-top: 4px;">
                    Qty: ${details.quantity} × ₹${details.price} = <strong>₹${details.price * details.quantity}</strong>
                </div>
            </div>
            <button onclick="removeFromCart('${name}')" style="background: #ff6b6b; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 600; transition: all 0.3s;">Remove</button>
        `;
        cartItems.appendChild(itemDiv);
    }
    document.getElementById('total-price').textContent = total;
    updateCartBadge();
}

function updateCartBadge() {
    const badge = document.getElementById('cart-badge');
    if (badge) {
        badge.textContent = cart.length;
        badge.style.display = cart.length > 0 ? 'flex' : 'none';
    }
}

function showNotification(message) {
    // Remove existing notification if any
    const existing = document.getElementById('cart-notification');
    if (existing) existing.remove();

    const notification = document.createElement('div');
    notification.id = 'cart-notification';
    notification.style.cssText = `
        position: fixed;
        top: 90px;
        right: 20px;
        background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        z-index: 999;
        font-weight: 600;
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 3000);
}

function toggleCart() {
    const panel = document.getElementById('cart-panel');
    if (panel) {
        panel.classList.toggle('open');
    }
}

function clearCart() {
    cart = [];
    total = 0;
    updateCart();
    showNotification('🗑️ Cart cleared!');
}
document.addEventListener('DOMContentLoaded', function () {
    // Cart event listeners
    document.getElementById('close-cart').addEventListener('click', toggleCart);
    document.getElementById('place-order').addEventListener('click', () => {
        if (cart.length === 0) {
            alert('Your cart is empty!');
        } else {
            // Store cart data before showing checkout
            currentCheckout = {
                items: JSON.parse(JSON.stringify(cart)),
                total: total
            };
            showCheckout();
            toggleCart();
        }
    });
});

function showCheckout() {
    document.getElementById('checkout-modal').classList.add('open');
}

function closeCheckout() {
    document.getElementById('checkout-modal').classList.remove('open');
    currentCheckout = null;
}

function submitCheckout(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('checkout-form'));
    const checkoutData = {
        customer_name: formData.get('customer_name'),
        email: formData.get('email'),
        contact: formData.get('contact'),
        address: formData.get('address'),
        city: formData.get('city'),
        state: formData.get('state'),
        pincode: formData.get('pincode'),
        cart: currentCheckout.items,
        total: currentCheckout.total
    };

    // Static / no-PHP hosting fallback
    const isFileProtocol = window.location.protocol === 'file:';
    const isLiveServer = window.location.hostname === '127.0.0.1' && window.location.port === '5500';

    if (isFileProtocol || isLiveServer) {
        // Running as a static file or via Live Server - generate bill without database
        handleOfflineOrder(checkoutData, isFileProtocol ? 'file protocol' : 'Live Server');
    } else {
        // Running on a PHP server or another backend-capable host
        fetch('process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(checkoutData)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Backend unavailable');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    generateBillWithInvoice(data.invoice_number, data.order_date, checkoutData, data.order_id);
                    closeCheckout();
                    document.getElementById('checkout-form').reset();
                    clearCart();
                    alert('Order placed successfully! Invoice: ' + data.invoice_number);
                } else if (/invalid request method|invalid json data|failed to process order/i.test(data.message)) {
                    handleOfflineOrder(checkoutData, data.message);
                } else {
                    alert('Error processing order: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                handleOfflineOrder(checkoutData, error.message);
            });
    }
}

function handleOfflineOrder(checkoutData, reason) {
    const invoiceNumber = 'VK' + String(Math.floor(Math.random() * 100) + 1).padStart(2, '0');
    const orderDate = new Date().toLocaleDateString('en-IN') + ' ' + new Date().toLocaleTimeString();
    const orderId = Date.now();

    generateBillWithInvoice(invoiceNumber, orderDate, checkoutData, orderId);
    closeCheckout();
    document.getElementById('checkout-form').reset();
    clearCart();
    alert('Order placed successfully! Backend unavailable, so the data is not saved to a database.' + (reason ? ' (' + reason + ')' : ''));
}

function generateBillWithInvoice(invoiceNumber, orderDate, checkoutData, orderId) {
    // Group items by name to handle quantities
    const itemMap = {};
    checkoutData.cart.forEach(item => {
        if (itemMap[item.name]) {
            itemMap[item.name].quantity += 1;
        } else {
            itemMap[item.name] = { price: item.price, quantity: 1 };
        }
    });

    // Business details
    const businessDetails = {
        name: "VK Chekku Ennai",
        address: "Traditional Oil Manufacturing, Tamil Nadu, India",
        contact: "+91 9025792835",
        email: "vkchekkuennai@gmail.com",
        gst: "GSTIN: 33XXXXXXXXXX" // Replace with actual GST number
    };

    // Create professional invoice HTML
    let billHTML = `
        <div id="bill-modal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 2000; display: flex; justify-content: center; align-items: center; font-family: 'Arial', sans-serif;">
            <div style="background: white; padding: 40px; border-radius: 15px; max-width: 800px; width: 95%; max-height: 95%; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3); border: 3px solid #ecc545;">

                <!-- Header with Logo -->
                <div style="text-align: center; margin-bottom: 30px; border-bottom: 3px solid #ecc545; padding-bottom: 20px;">
                    <div style="display: inline-block; background: linear-gradient(135deg, #ecc545 0%, #d4a93e 100%); padding: 15px 30px; border-radius: 15px; margin-bottom: 10px;">
                        <div style="font-size: 36px; font-weight: bold; color: #2d2d2d;">🫒 VK CHEKKU ENNAI</div>
                    </div>
                    <div style="font-size: 14px; color: #666; margin-bottom: 15px;">Pure, Traditional Chekku Oil</div>
                    <div style="background: linear-gradient(135deg, #ecc545 0%, #d4a93e 100%); height: 4px; border-radius: 2px; margin: 0 auto; width: 100px;"></div>
                </div>

                <!-- Invoice Title -->
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="font-size: 28px; color: #2d2d2d; margin: 0; font-weight: bold;">INVOICE</h1>
                </div>

                <!-- Invoice Details -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin: 30px 0; padding: 20px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-radius: 10px; border: 1px solid #ecc545;">

                    <!-- From Address (Business Details) -->
                    <div style="border-right: 2px solid #ecc545; padding-right: 20px;">
                        <h3 style="color: #2d2d2d; margin: 0 0 15px 0; font-size: 16px; font-weight: bold; border-bottom: 1px solid #ecc545; padding-bottom: 5px;">FROM:</h3>
                        <div style="font-size: 14px; line-height: 1.6;">
                            <strong>${businessDetails.name}</strong><br>
                            ${businessDetails.address}<br>
                            <strong>Contact:</strong> ${businessDetails.contact}<br>
                            <strong>Email:</strong> ${businessDetails.email}<br>
                            <strong>${businessDetails.gst}</strong>
                        </div>
                    </div>

                    <!-- To Address (Customer Details) -->
                    <div>
                        <h3 style="color: #2d2d2d; margin: 0 0 15px 0; font-size: 16px; font-weight: bold; border-bottom: 1px solid #ecc545; padding-bottom: 5px;">TO:</h3>
                        <div style="font-size: 14px; line-height: 1.6;">
                            <strong>${checkoutData.customer_name}</strong><br>
                            ${checkoutData.address}<br>
                            ${checkoutData.city}, ${checkoutData.state} ${checkoutData.pincode}<br>
                            <strong>Contact:</strong> ${checkoutData.contact}<br>
                            <strong>Email:</strong> ${checkoutData.email}
                        </div>
                    </div>
                </div>

                <!-- Invoice Meta Information -->
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin: 25px 0; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <div style="text-align: center;">
                        <strong style="color: #2d2d2d;">Invoice No:</strong><br>
                        <span style="font-size: 16px; color: #e74c3c; font-weight: bold;">${invoiceNumber}</span>
                    </div>
                    <div style="text-align: center;">
                        <strong style="color: #2d2d2d;">Order ID:</strong><br>
                        <span style="font-size: 14px;">${orderId}</span>
                    </div>
                    <div style="text-align: center;">
                        <strong style="color: #2d2d2d;">Date & Time:</strong><br>
                        <span style="font-size: 14px;">${orderDate}</span>
                    </div>
                    <div style="text-align: center;">
                        <strong style="color: #2d2d2d;">Payment:</strong><br>
                        <span style="font-size: 14px; color: #27ae60;">Cash on Delivery</span>
                    </div>
                </div>

                <!-- Products Table -->
                <table style="width: 100%; border-collapse: collapse; margin: 30px 0; border: 2px solid #ecc545; border-radius: 8px; overflow: hidden;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #ecc545 0%, #d4a93e 100%); color: #2d2d2d;">
                            <th style="padding: 15px; text-align: left; font-weight: bold; font-size: 14px; border-right: 1px solid rgba(255,255,255,0.3);">Product</th>
                            <th style="padding: 15px; text-align: center; font-weight: bold; font-size: 14px; border-right: 1px solid rgba(255,255,255,0.3);">Qty</th>
                            <th style="padding: 15px; text-align: right; font-weight: bold; font-size: 14px; border-right: 1px solid rgba(255,255,255,0.3);">Unit Price</th>
                            <th style="padding: 15px; text-align: right; font-weight: bold; font-size: 14px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>`;

    for (const [name, details] of Object.entries(itemMap)) {
        billHTML += `
                        <tr style="border-bottom: 1px solid #eee; background: #fafafa;">
                            <td style="padding: 15px; font-weight: 600; color: #2d2d2d; border-right: 1px solid #eee;">${name}</td>
                            <td style="padding: 15px; text-align: center; border-right: 1px solid #eee;">${details.quantity}</td>
                            <td style="padding: 15px; text-align: right; border-right: 1px solid #eee;">₹${details.price}</td>
                            <td style="padding: 15px; text-align: right; font-weight: bold; color: #e74c3c;">₹${details.price * details.quantity}</td>
                        </tr>`;
    }

    billHTML += `
                    </tbody>
                    <tfoot>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-top: 2px solid #ecc545;">
                            <td colspan="3" style="text-align: right; padding: 20px; font-weight: bold; font-size: 16px; color: #2d2d2d;">Grand Total:</td>
                            <td style="text-align: right; padding: 20px; font-weight: bold; font-size: 18px; color: #27ae60;">₹${checkoutData.total}</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Terms and Conditions -->
                <div style="margin: 30px 0; padding: 20px; background: #fff8e1; border: 1px solid #ecc545; border-radius: 8px;">
                    <h4 style="margin: 0 0 10px 0; color: #2d2d2d; font-size: 14px;">Terms & Conditions:</h4>
                    <ul style="font-size: 12px; line-height: 1.6; color: #555; margin: 0; padding-left: 20px;">
                        <li>Payment to be made in cash upon delivery</li>
                        <li>All products are fresh and pure traditional chekku oil</li>
                        <li>Delivery within 3-5 business days</li>
                        <li>For any queries, contact us at ${businessDetails.contact}</li>
                    </ul>
                </div>

                <!-- Footer -->
                <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 2px solid #ecc545;">
                    <div style="font-size: 14px; color: #666; margin-bottom: 10px;">
                        Thank you for choosing <strong>VK Chekku Ennai</strong> - Pure, Traditional, Healthy!
                    </div>
                    <div style="font-size: 12px; color: #999;">
                        This is a computer-generated invoice and does not require signature.
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="text-align: center; margin-top: 30px;">
                    <button onclick="downloadPDFWithInvoice('${invoiceNumber}', '${orderDate}', ${JSON.stringify(itemMap).replace(/"/g, '&quot;')}, ${checkoutData.total}, ${JSON.stringify(checkoutData).replace(/"/g, '&quot;')}, ${JSON.stringify(businessDetails).replace(/"/g, '&quot;')})" style="margin: 0 10px; padding: 14px 24px; background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);">📄 Download PDF</button>
                    <button onclick="window.print()" style="margin: 0 10px; padding: 14px 24px; background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);">🖨️ Print Invoice</button>
                    <button onclick="closeBillAndClear()" style="margin: 0 10px; padding: 14px 24px; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);">❌ Close</button>
                </div>
            </div>
        </div>`;

    document.body.insertAdjacentHTML('beforeend', billHTML);
}

function closeBillAndClear() {
    const modal = document.getElementById('bill-modal');
    if (modal) {
        modal.remove();
    }
    cart = [];
    total = 0;
    updateCart();
}

function downloadPDFWithInvoice(invoiceNumber, orderDate, itemMap, total, checkoutData, businessDetails) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Set default font
    doc.setFont('helvetica');

    // Header with Logo/Brand
    doc.setFillColor(236, 197, 69); // Golden color
    doc.rect(0, 0, 210, 30, 'F');

    doc.setFontSize(24);
    doc.setTextColor(45, 45, 45); // Dark color
    doc.setFont('helvetica', 'bold');
    doc.text('VK CHEKKU ENNAI', 105, 15, { align: 'center' });

    doc.setFontSize(12);
    doc.setFont('helvetica', 'normal');
    doc.text('Pure, Traditional Chekku Oil', 105, 22, { align: 'center' });

    // Invoice title
    doc.setFontSize(20);
    doc.setFont('helvetica', 'bold');
    doc.text('INVOICE', 105, 40, { align: 'center' });

    let y = 55;

    // Business Details (From Address)
    doc.setFontSize(12);
    doc.setFont('helvetica', 'bold');
    doc.text('FROM:', 20, y);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    y += 8;
    doc.text(businessDetails.name, 20, y);
    y += 5;
    doc.text(businessDetails.address, 20, y);
    y += 5;
    doc.text('Contact: ' + businessDetails.contact, 20, y);
    y += 5;
    doc.text('Email: ' + businessDetails.email, 20, y);
    y += 5;
    doc.text(businessDetails.gst, 20, y);

    // Customer Details (To Address) - positioned on the right
    let customerY = 55;
    doc.setFontSize(12);
    doc.setFont('helvetica', 'bold');
    doc.text('TO:', 120, customerY);
    doc.setFont('helvetica', 'normal');
    doc.setFontSize(10);
    customerY += 8;
    doc.text(checkoutData.customer_name, 120, customerY);
    customerY += 5;
    // Split address into lines if too long
    const addressLines = doc.splitTextToSize(checkoutData.address, 70);
    for (let line of addressLines) {
        doc.text(line, 120, customerY);
        customerY += 5;
    }
    doc.text(checkoutData.city + ', ' + checkoutData.state + ' ' + checkoutData.pincode, 120, customerY);
    customerY += 5;
    doc.text('Contact: ' + checkoutData.contact, 120, customerY);
    customerY += 5;
    doc.text('Email: ' + checkoutData.email, 120, customerY);

    y = Math.max(y, customerY) + 15;

    // Invoice Details
    doc.setFillColor(248, 249, 250); // Light gray background
    doc.rect(20, y - 5, 170, 15, 'F');
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.setTextColor(45, 45, 45);

    doc.text('Invoice No: ' + invoiceNumber, 25, y + 2);
    doc.text('Date & Time: ' + orderDate, 85, y + 2);
    doc.text('Payment: Cash on Delivery', 145, y + 2);

    y += 20;

    // Table Header
    doc.setFillColor(236, 197, 69); // Golden header
    doc.rect(20, y, 170, 12, 'F');
    doc.setTextColor(45, 45, 45);
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');

    doc.text('Product', 25, y + 8);
    doc.text('Qty', 100, y + 8);
    doc.text('Unit Price', 130, y + 8);
    doc.text('Total', 170, y + 8);

    y += 15;

    // Table Content
    doc.setFont('helvetica', 'normal');
    doc.setTextColor(0, 0, 0);

    for (const [name, details] of Object.entries(itemMap)) {
        // Alternate row colors
        if (Object.keys(itemMap).indexOf(name) % 2 === 0) {
            doc.setFillColor(250, 250, 250);
            doc.rect(20, y - 2, 170, 10, 'F');
        }

        doc.text(name.substring(0, 30), 25, y + 5);
        doc.text(details.quantity.toString(), 100, y + 5);
        doc.text('₹' + details.price, 130, y + 5);
        doc.text('₹' + (details.price * details.quantity), 170, y + 5);
        y += 10;
    }

    // Total
    y += 5;
    doc.setDrawColor(236, 197, 69);
    doc.setLineWidth(0.5);
    doc.line(20, y, 190, y);
    y += 10;

    doc.setFont('helvetica', 'bold');
    doc.setFontSize(12);
    doc.text('Grand Total: ₹' + total, 130, y);

    // Terms and Conditions
    y += 20;
    doc.setFontSize(10);
    doc.setFont('helvetica', 'bold');
    doc.text('Terms & Conditions:', 20, y);
    y += 8;

    doc.setFont('helvetica', 'normal');
    doc.setFontSize(8);
    const terms = [
        '• Payment to be made in cash upon delivery',
        '• All products are fresh and pure traditional chekku oil',
        '• Delivery within 3-5 business days',
        '• For any queries, contact us at ' + businessDetails.contact
    ];

    for (let term of terms) {
        doc.text(term, 20, y);
        y += 5;
    }

    // Footer
    y += 15;
    doc.setFontSize(10);
    doc.setFont('helvetica', 'italic');
    doc.text('Thank you for choosing VK Chekku Ennai - Pure, Traditional, Healthy!', 105, y, { align: 'center' });
    y += 8;
    doc.setFontSize(8);
    doc.text('This is a computer-generated invoice and does not require signature.', 105, y, { align: 'center' });

    // Save the PDF
    doc.save(`VK_Invoice_${invoiceNumber}.pdf`);
}
