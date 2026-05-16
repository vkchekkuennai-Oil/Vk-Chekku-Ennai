# VK Chekku Ennai - Complete E-Commerce Billing System

## 🫒 Overview

A complete e-commerce website for VK Chekku Ennai with professional billing system, automatic invoice generation, and admin panel for order management.

## ✨ Features

### 🛒 Shopping Cart
- Modern, responsive cart interface with animations
- Real-time quantity updates and total calculations
- Professional styling with golden theme

### 📋 Checkout System
- Complete customer information form
- Address, contact, and delivery details collection
- Form validation and user-friendly interface

### 🧾 Invoice Generation
- **Professional invoice design** with brand logo
- **Business details** in "From Address" section
- **Customer details** in "To Address" section
- **Sequential invoice numbering** (VK01, VK02, VK03...)
- **Product breakdown** with quantities and pricing
- **PDF download** functionality
- **Print-ready** invoice format

### 💾 Database Integration
- **MySQL database** for order storage
- **Sequential invoice ID** generation
- **Order history** tracking
- **Customer data** management

### 👨‍💼 Admin Panel
- **Secure admin login**
- **Order management** dashboard
- **Invoice viewing** and tracking
- **Customer order history**

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP 7+
- **Database**: MySQL
- **PDF Generation**: jsPDF Library
- **Styling**: Custom CSS with gradients and animations

## 📁 Project Structure

```
vk-chekku-ennai/
├── index.html              # Main website
├── script.js               # Frontend functionality
├── stylesheet.css          # Styling and cart design
├── admin.php               # Admin dashboard
├── admin_login.php         # Admin authentication
├── process_order.php       # Order processing backend
├── db_config.php           # Database configuration
├── setup_database.php      # Database initialization
├── get_orders.php          # Order retrieval API
├── get_invoice_details.php # Invoice details API
└── README.md              # This file
```

## 🚀 Installation & Setup

### Prerequisites
- PHP 7.0 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

### Windows Setup (Recommended)

1. **Install XAMPP** (includes PHP, MySQL, Apache):
   ```bash
   winget install ApacheFriends.Xampp.8.2
   ```

2. **Run the setup script**:
   ```bash
   quick_setup.bat
   ```
   Or follow manual steps below:

3. **Manual Setup**:
   - Run XAMPP Control Panel as Administrator
   - Start Apache and MySQL modules
   - Open browser: `http://localhost/phpmyadmin`
   - Create database: `vk_chekku_ennai`
   - Copy project to: `C:\xampp\htdocs\vk`
   - Run: `http://localhost/vk/setup_database.php`
   - Or import `database.sql` in phpMyAdmin to create the database and tables manually

4. **Access the website**:
   - Main site: `http://localhost/vk/`
   - Admin panel: `http://localhost/vk/admin_login.php`

### Database Configuration
Edit `db_config.php` with your database credentials:
```php
$servername = "localhost";
$username = "root";  // Default XAMPP username
$password = "";      // Default XAMPP password (empty)
$dbname = "vk_chekku_ennai";
```

## 📋 Usage

### For Customers
1. **Browse Products**: View available chekku oil products
2. **Add to Cart**: Click "Add to Cart" on desired products
3. **View Cart**: Click cart icon to see items and totals
4. **Checkout**: Fill customer details form
5. **Generate Invoice**: Automatic invoice creation with PDF download

### For Admins
1. **Login**: Visit `admin_login.php` (default: admin/admin123)
2. **View Orders**: See all customer orders and invoices
3. **Track Sales**: Monitor business performance

## 🧾 Invoice Features

### Invoice Format
- **Invoice Number**: VK01, VK02, VK03... (sequential)
- **Business Header**: VK Chekku Ennai branding
- **From/To Addresses**: Complete business and customer details
- **Product Table**: Itemized products with quantities and prices
- **Totals**: Subtotal, tax (optional), grand total
- **Terms & Conditions**: Delivery and payment terms

### PDF Generation
- Professional layout optimized for printing
- Company branding and logo
- Clear typography and spacing
- Downloadable and printable format

## 🔒 Security Features

- **Input validation** on all forms
- **SQL injection prevention** with prepared statements
- **Secure admin authentication**
- **Session management** for admin access

## 🎨 Design Features

- **Responsive design** for all devices
- **Golden theme** matching brand colors
- **Smooth animations** and transitions
- **Modern UI/UX** with intuitive navigation
- **Professional invoice styling**

## 📞 Business Information

**VK Chekku Ennai**
- Pure, traditional chekku oil
- Traditional manufacturing methods
- No chemicals or adulteration
- Health-focused products

## 🆘 Troubleshooting

### Database Connection Issues
- Verify MySQL server is running
- Check database credentials in `db_config.php`
- Ensure database `vk_chekku_ennai` exists

### Invoice Generation Issues
- Ensure jsPDF library is loaded
- Check browser console for JavaScript errors
- Verify all form fields are filled

### Admin Login Issues
- Default credentials: admin / admin123
- Check PHP session configuration

## 📈 Future Enhancements

- Email invoice delivery
- Payment gateway integration
- Inventory management
- Customer accounts and order history
- Multi-language support
- Advanced reporting dashboard

## � GitHub Repository

This project is ready to push to GitHub as a source repository.

1. Initialize git (if not already):
   ```bash
git init
git add .
git commit -m "Initial project commit"
   ```
2. Create a new GitHub repository and add the remote:
   ```bash
git remote add origin https://github.com/<username>/<repo>.git
git push -u origin main
   ```

> Note: GitHub Pages cannot run PHP or MySQL. This repository stores the source code only.
> 
> The app now includes a static fallback for Vercel / static hosts and Live Server on `127.0.0.1:5500`: order invoices can be generated in-browser, but order data is not saved to a database unless you use a PHP backend.

## �📝 License

This project is developed for VK Chekku Ennai business use.

## 👥 Support

For technical support or customization requests:
- Email: sabarisundaram16@gmail.com
- Contact: +91 9025792835

---

**VK Chekku Ennai** - Pure, Traditional, Healthy! 🫒
├── get_invoice_details.php # Get invoice details
├── setup_database.php  # Database setup script
└── img/                # Product images
```

## Database Tables

### orders
- id (Primary Key)
- invoice_number (Unique)
- customer_name
- email
- contact
- address, city, state, pincode
- total_amount
- order_date

### order_items
- id (Primary Key)
- order_id (Foreign Key)
- product_name
- quantity
- price
- total_price

### admin_users
- id (Primary Key)
- username (Unique)
- password (Hashed)
- created_at

## Usage

1. **Customer Journey:**
   - Browse products
   - Add items to cart
   - Click "Place Order"
   - Fill checkout form
   - View/download/print invoice

2. **Admin Features:**
   - View all orders
   - See order statistics
   - View detailed invoices
   - Print/download invoices

## Security Notes

- Change the default admin password in production
- Use HTTPS in production
- Implement proper input validation and sanitization
- Consider using prepared statements (already implemented)

## Technologies Used

- HTML5, CSS3, JavaScript
- PHP 7+
- MySQL
- jsPDF (for PDF generation)
- Font Awesome/Unicons (for icons)