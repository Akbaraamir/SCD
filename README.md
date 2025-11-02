# Hope4Paws – Animal Adoption Management System

A secure, responsive PHP/MySQL web application for animal shelters to manage adoptable animals with **user ownership** and **admin oversight**.

*Warm brown & orange theme designed for compassion and clarity*

## ✨ Features

### User Management
- Staff signup/login with password hashing
- Session-based authentication
- Role-based access: **Staff** vs **Admin**

### Animal Management (CRUD)
- **Staff**: Add, view, edit, and delete **only their own animals**
- **Admin**: View **all animals** (but can only edit/delete their own for security)
- Search animals by name
- Responsive card-based layout

### Security
- Passwords hashed with `password_hash()`
- Ownership verification on edit/delete
- XSS protection with `htmlspecialchars()`
- SQL injection mitigated via ownership checks

### Design
- Custom **"Sunny Shelter"** theme: warm browns & oranges
- Mobile-responsive (works on all devices)
- Accessible color contrast and clear buttons

## 🛠️ Technologies Used
- **Frontend**: HTML5, CSS3, Font Awesome
- **Backend**: PHP 8 (procedural)
- **Database**: MySQL
- **Server**: Apache (XAMPP)
- **Tools**: Git, GitHub

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Akbaraamir/SCD.git
