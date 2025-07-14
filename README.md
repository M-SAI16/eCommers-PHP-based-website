# Project Overview
This project is a simple yet functional eCommerce web application built using PHP and MySQL. It provides a basic shopping experience along with an admin panel to manage the product catalog. The frontend allows users to view products, and the backend enables admins to add, edit, delete, and manage products from a secure dashboard.

It’s a great project for beginners to learn full-stack web development with PHP, and also understand CRUD operations, form handling, and session-based authentication.

# Methodology
The development follows a structured approach divided into frontend, backend, and database interaction layers:

# Requirement Analysis:

Objective: Build an eCommerce platform with product management.

Roles: Admin (Add/Edit/Delete products), User (Browse Products).

Design:

Frontend design using HTML and CSS (style.css).

Admin panel structure built with individual PHP pages.

Cart functionality implied (images/cart-icon.png).

Development:

PHP used for backend scripting.

test_db.php for database connection testing.

Admin panel handles:

Product creation (add_product.php)

Product modification (edit_product.php)

Product deletion (delete_product.php)

Product listing (manage_products.php)

Testing:

Functional testing through browser (e.g., localhost/ecommerce/pages/index.php).

Database connectivity check via test_db.php.

Deployment:

Suitable for deployment on local server environments like XAMPP or WAMP.

# Installation Steps
1. Requirements
PHP (v7.x or higher)

MySQL Database

Web Server (XAMPP/WAMP/LAMP)

2. Steps to Run
Download or clone the project.

Place the folder in the web root directory (e.g., htdocs in XAMPP).

Start Apache and MySQL from XAMPP.

Create a new MySQL database (e.g., ecommerce).

Configure the test_db.php file with your MySQL credentials.

# Run the site:

ruby
Copy
Edit
http://localhost/ecommerce/pages/index.php

 # Libraries/Tools Used
Technology	                          Purpose
PHP	Server-                        side scripting
MySQL	                            Database backend
HTML/CSS	                      Frontend layout and styling
XAMPP/WAMP	                 Local development environment
Apache                      	Web server(via XAMPP/WAMP)
