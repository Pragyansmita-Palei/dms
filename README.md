# DMS – Admin and Customer Dashboard

This repository contains a mini DMS (Dashboard Management System) application with an Admin and Customer dashboard.  
It provides user management, authentication, and clean UI screens for both admin and customer roles.

---

##  Features

- Admin Dashboard  
- Customer Dashboard  
- User Login & Authentication  
- CRUD Operations  
- Responsive UI  
- Organized project structure  
- Easy setup for local development

---

## Project Structure

mini-dms/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
└── ...



---

##  Installation Guide

Follow the steps below to run the project on your local system.

---

1.  Clone the Repository**
```bash
git clone https://github.com/Pragyansmita-Palei/dms.git
cd dms/mini-dms


2. Install Dependencies

Make sure you have Composer installed, then run:

composer install

3. Setup Environment File

Copy the example environment file:

cp .env.example .env


Then update your database name, username, and password inside the .env file.

4. Generate Laravel Application Key
php artisan key:generate

5. Run Database Migrations
php artisan migrate

6. Start the Local Development Server
php artisan serve
