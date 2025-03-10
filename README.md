# Invoices Management System
A simple and lightweight web application built with Laravel to manage invoices. This project allows users to create, view, update, and delete invoices efficiently. It’s designed for small businesses or individuals who need a basic invoicing solution.

# Features
Create new invoices with customer details and items.
View a list of all invoices.
Edit or delete existing invoices.
Simple and user-friendly interface.
Built-in validation and error handling.
# Screen Shots
HOME
![home](https://github.com/user-attachments/assets/805972dc-1132-4122-b66b-523ea7bdeb9e)
LogIn
![login](https://github.com/user-attachments/assets/7c684b74-179d-4131-8aad-9ad46b38496d)
Invoices
![invoices](https://github.com/user-attachments/assets/3381738d-3710-4daf-973d-490befeedac8)
Users
![users](https://github.com/user-attachments/assets/0b883d1e-eadb-4d47-9fc3-cae8d086fffc)
Roles
![roles](https://github.com/user-attachments/assets/0aaf103a-4ad0-46b4-83d4-592a490c3d71)
Sections
![section1](https://github.com/user-attachments/assets/7167a503-810b-4af1-a5da-a6b6e63d6e97)
Product
![product](https://github.com/user-attachments/assets/87596076-5171-42ec-8ef5-c33c5263b96f)

# Technologies Used
Laravel: PHP framework (v11.x).
MySQL: Database for storing invoices and related data.
Bootstrap: For responsive and clean UI.
PHPUnit: For unit testing (optional).
Prerequisites
Before you begin, ensure you have the following installed:

PHP >= 8.1
Composer
MySQL (or any supported database)
Node.js & NPM  
# Installation
Clone the repository:
git clone https://github.com/your-username/invoices.git
cd invoices
Install dependencies:
composer install
npm install  # If using front-end assets
Set up environment file:
Copy .env.example to .env:

cp .env.example .env
Update the .env file with your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invoices
DB_USERNAME=your_username
DB_PASSWORD=your_password
Generate application key:
bash


php artisan key:generate
Run migrations:

php artisan migrate
Seed the database (optional):
php artisan db:seed
Start the development server:

php artisan serve
Open your browser and visit: http://localhost:8000.
# Usage
Navigate to the homepage to see the list of invoices.
Use the "Create Invoice" button to add a new invoice.
Click on an invoice to view details or edit it.
Delete invoices as needed from the interface.
