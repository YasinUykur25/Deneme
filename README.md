# 🔐 PHP Login and Password Reset System

A secure and modern user login system built with PHP and MySQL, featuring real email-based password reset functionality using **PHPMailer**.  
Includes stylish glassmorphism UI, smooth animations, and a locked favicon icon 🔒

## 🧩 Features

- ✅ User Registration
- ✅ Login & Session Management
- ✅ Secure password hashing with `password_hash()`
- ✅ "Forgot Password" with email reset link
- ✅ Token-based password reset system
- ✅ Real-time email sending via Gmail (SMTP)
- ✅ PHPMailer integration
- ✅ Responsive & modern UI (glass effect, animations)
- ✅ Favicon support (lock icon)

## 💾 Technologies Used

- PHP 7+
- MySQL (phpMyAdmin)
- HTML5 / CSS3
- PHPMailer
- Gmail SMTP
- XAMPP (for localhost testing)

## 🔧 Installation

1. Clone or download this project
2. Place it inside your XAMPP `htdocs` folder  
   (Example: `C:\xampp\htdocs\deneme`)
3. Create a MySQL database named: `giris_sistemi`
4. Import or manually create a `users` table with columns:
   - `id`, `username`, `email`, `password`, `reset_token`
5. Configure your database credentials in `db.php`
## 🖼️ Screenshot

![Login Screen](screenshot.png)

