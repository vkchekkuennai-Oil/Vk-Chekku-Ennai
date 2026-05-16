<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Order Management | VK Chekku Ennai</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ececd5;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #333;
            font-size: 28px;
        }

        .logout-btn {
            background: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }

        .logout-btn:hover {
            background: #da190b;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: linear-gradient(135deg, #ececd5 0%, #e8e8cc 100%);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .stat-box h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .stat-box .value {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table thead {
            background: #ececd5;
        }

        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        table tr:hover {
            background: #fafafa;
        }

        .action-btn {
            background: #2196F3;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
        }

        .action-btn:hover {
            background: #0b7dda;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .modal.open {
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 700px;
            width: 90%;
            max-height: 90%;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
        }

        .invoice-details {
            margin: 20px 0;
        }

        .invoice-details p {
            margin: 8px 0;
            font-size: 14px;
        }

        .invoice-details strong {
            color: #333;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .invoice-table thead {
            background: #f5f5f5;
        }

        .invoice-table th {
            padding: 10px;
            text-align: left;
            font-weight: 600;
        }

        .invoice-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .modal-actions button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
        }

        .print-btn {
            background: #4CAF50;
            color: white;
        }

        .print-btn:hover {
            background: #45a049;
        }

        .download-btn {
            background: #FF9800;
            color: white;
        }

        .download-btn:hover {
            background: #e68900;
        }

        .error {
            background: #f44336;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .stats {
                grid-template-columns: 1fr;
            }

            table {
                font-size: 12px;
            }

            table th, table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Order Management</h1>
            <button class="logout-btn" onclick="logout()">Logout</button>
        </div>

        <div id="message"></div>

        <div class="stats">
            <div class="stat-box">
                <h3>Total Orders</h3>
                <div class="value" id="total-orders">0</div>
            </div>
            <div class="stat-box">
                <h3>Total Revenue</h3>
                <div class="value" id="total-revenue">₹0</div>
            </div>
            <div class="stat-box">
                <h3>Today's Orders</h3>
                <div class="value" id="today-orders">0</div>
            </div>
        </div>

        <div class="search-box">
            <input type="text" id="search-input" placeholder="Search by Invoice No., Customer Name, or Email...">
        </div>

        <table>
            <thead>
                <tr>
                    <th>Invoice No.</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="orders-table">
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Invoice Detail Modal -->
    <div id="invoice-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Invoice Details</h2>
                <button class="close-modal" onclick="closeInvoiceModal()">&times;</button>
            </div>
            <div id="invoice-details-content"></div>
            <div class="modal-actions">
                <button class="print-btn" onclick="printInvoice()">Print Invoice</button>
                <button class="download-btn" onclick="downloadInvoicePDF()">Download PDF</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        let allOrders = [];
        let selectedInvoiceData = null;

        // Load orders on page load
        window.addEventListener('load', loadOrders);

        // Search functionality
        document.getElementById('search-input').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            filterOrders(query);
        });

        function loadOrders() {
            fetch('get_orders.php')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        allOrders = data.orders;
                        displayOrders(allOrders);
                        updateStats(data.stats);
                    } else {
                        showMessage('Error loading orders: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Error loading orders', 'error');
                });
        }

        function displayOrders(orders) {
            const tbody = document.getElementById('orders-table');
            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px;">No orders found</td></tr>';
                return;
            }

            tbody.innerHTML = orders.map(order => `
                <tr>
                    <td><strong>${order.invoice_number}</strong></td>
                    <td>${order.customer_name}</td>
                    <td>${order.email}</td>
                    <td>${order.contact}</td>
                    <td>₹${parseFloat(order.total_amount).toFixed(2)}</td>
                    <td>${new Date(order.order_date).toLocaleDateString('en-IN')}</td>
                    <td>
                        <button class="action-btn" onclick="viewInvoice('${order.invoice_number}')">View</button>
                    </td>
                </tr>
            `).join('');
        }

        function filterOrders(query) {
            const filtered = allOrders.filter(order =>
                order.invoice_number.toLowerCase().includes(query) ||
                order.customer_name.toLowerCase().includes(query) ||
                order.email.toLowerCase().includes(query)
            );
            displayOrders(filtered);
        }

        function updateStats(stats) {
            document.getElementById('total-orders').textContent = stats.total_orders;
            document.getElementById('total-revenue').textContent = '₹' + parseFloat(stats.total_revenue).toFixed(2);
            document.getElementById('today-orders').textContent = stats.today_orders;
        }

        function viewInvoice(invoiceNumber) {
            fetch(`get_invoice_details.php?invoice_number=${invoiceNumber}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        selectedInvoiceData = data;
                        displayInvoiceModal(data);
                    } else {
                        showMessage('Error loading invoice: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Error loading invoice', 'error');
                });
        }

        function displayInvoiceModal(data) {
            const invoice = data.invoice;
            const items = data.items;

            let itemsHTML = items.map(item => `
                <tr>
                    <td>${item.product_name}</td>
                    <td style="text-align: center;">${item.quantity}</td>
                    <td style="text-align: right;">₹${parseFloat(item.price).toFixed(2)}</td>
                    <td style="text-align: right;">₹${parseFloat(item.total_price).toFixed(2)}</td>
                </tr>
            `).join('');

            const html = `
                <div class="invoice-details">
                    <p><strong>Invoice Number:</strong> ${invoice.invoice_number}</p>
                    <p><strong>Order Date:</strong> ${new Date(invoice.order_date).toLocaleDateString('en-IN', { year: 'numeric', month: 'long', day: 'numeric' })} ${new Date(invoice.order_date).toLocaleTimeString()}</p>
                </div>

                <div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 20px 0;">
                    <h3 style="margin-top: 0; margin-bottom: 10px;">Customer Information</h3>
                    <p><strong>Name:</strong> ${invoice.customer_name}</p>
                    <p><strong>Email:</strong> ${invoice.email}</p>
                    <p><strong>Contact:</strong> ${invoice.contact}</p>
                    <p><strong>Address:</strong> ${invoice.address}, ${invoice.city}, ${invoice.state} ${invoice.pincode}</p>
                </div>

                <h3>Order Items</h3>
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${itemsHTML}
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid #333; font-weight: bold;">
                            <td colspan="3" style="text-align: right;">Total Amount:</td>
                            <td style="text-align: right;">₹${parseFloat(invoice.total_amount).toFixed(2)}</td>
                        </tr>
                    </tfoot>
                </table>
            `;

            document.getElementById('invoice-details-content').innerHTML = html;
            document.getElementById('invoice-modal').classList.add('open');
        }

        function closeInvoiceModal() {
            document.getElementById('invoice-modal').classList.remove('open');
        }

        function printInvoice() {
            const printWindow = window.open('', '', 'height=600,width=800');
            const invoice = selectedInvoiceData.invoice;
            const items = selectedInvoiceData.items;

            let itemsHTML = items.map(item => `
                <tr>
                    <td>${item.product_name}</td>
                    <td style="text-align: center;">${item.quantity}</td>
                    <td style="text-align: right;">₹${parseFloat(item.price).toFixed(2)}</td>
                    <td style="text-align: right;">₹${parseFloat(item.total_price).toFixed(2)}</td>
                </tr>
            `).join('');

            const html = `
                <html>
                <head>
                    <title>Invoice ${invoice.invoice_number}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; }
                        .invoice-info { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin: 20px 0; }
                        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                        table, th, td { border: 1px solid #333; }
                        th, td { padding: 10px; text-align: left; }
                        .total { font-weight: bold; font-size: 16px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>VK CHEKKU ENNAI</h1>
                        <h2>Invoice</h2>
                    </div>

                    <div class="invoice-info">
                        <div>
                            <p><strong>Invoice Number:</strong> ${invoice.invoice_number}</p>
                            <p><strong>Order Date:</strong> ${new Date(invoice.order_date).toLocaleDateString('en-IN')}</p>
                        </div>
                        <div>
                            <p><strong>Customer:</strong> ${invoice.customer_name}</p>
                            <p><strong>Email:</strong> ${invoice.email}</p>
                            <p><strong>Contact:</strong> ${invoice.contact}</p>
                        </div>
                    </div>

                    <p><strong>Delivery Address:</strong><br>${invoice.address}<br>${invoice.city}, ${invoice.state} ${invoice.pincode}</p>

                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHTML}
                        </tbody>
                        <tfoot>
                            <tr class="total">
                                <td colspan="3" style="text-align: right;">Total Amount:</td>
                                <td>₹${parseFloat(invoice.total_amount).toFixed(2)}</td>
                            </tr>
                        </tfoot>
                    </table>
                </body>
                </html>
            `;

            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.print();
        }

        function downloadInvoicePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();
            const invoice = selectedInvoiceData.invoice;
            const items = selectedInvoiceData.items;

            doc.setFontSize(20);
            doc.text('VK CHEKKU ENNAI', 105, 15, { align: 'center' });
            doc.setFontSize(12);
            doc.text('Invoice', 105, 25, { align: 'center' });

            doc.setFontSize(10);
            doc.text(`Invoice Number: ${invoice.invoice_number}`, 20, 40);
            doc.text(`Order Date: ${new Date(invoice.order_date).toLocaleDateString('en-IN')}`, 20, 48);

            doc.text('Customer Details:', 20, 60);
            doc.setFontSize(9);
            doc.text(`Name: ${invoice.customer_name}`, 20, 68);
            doc.text(`Email: ${invoice.email}`, 20, 76);
            doc.text(`Contact: ${invoice.contact}`, 20, 84);
            doc.text(`Address: ${invoice.address}`, 20, 92);
            doc.text(`City: ${invoice.city}, State: ${invoice.state}, Pincode: ${invoice.pincode}`, 20, 100);

            let y = 115;
            doc.setFontSize(10);
            doc.text('Product', 25, y);
            doc.text('Qty', 100, y);
            doc.text('Unit Price', 130, y);
            doc.text('Total', 170, y);

            y += 10;
            doc.line(20, y, 190, y);
            y += 10;

            items.forEach(item => {
                doc.text(item.product_name.substring(0, 35), 25, y);
                doc.text(item.quantity.toString(), 100, y);
                doc.text(`₹${parseFloat(item.price).toFixed(2)}`, 130, y);
                doc.text(`₹${parseFloat(item.total_price).toFixed(2)}`, 170, y);
                y += 10;
            });

            y += 5;
            doc.line(20, y, 190, y);
            y += 10;
            doc.setFontSize(11);
            doc.setFont(undefined, 'bold');
            doc.text(`Total Amount: ₹${parseFloat(invoice.total_amount).toFixed(2)}`, 130, y);

            doc.save(`invoice_${invoice.invoice_number}.pdf`);
        }

        function showMessage(message, type) {
            const msgDiv = document.getElementById('message');
            msgDiv.textContent = message;
            msgDiv.className = type;
            setTimeout(() => {
                msgDiv.textContent = '';
                msgDiv.className = '';
            }, 5000);
        }

        function logout() {
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = 'admin_login.php?logout=true';
            }
        }
    </script>
</body>
</html>
