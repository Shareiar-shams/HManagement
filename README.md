## Hotel Management System

This is a hotel management system where users can search for rooms, book them, and pay using SSLCommerz payment gateway. The system also allows users to book a restaurant, view their invoices, and perform a variety of hotel-related actions. Admins can manage rooms, categories, floors, and view reports such as revenue and total bookings.

## Features

- **Room Booking:** Users can book rooms based on the check-in and check-out date, number of guests (adults and children), and the preferred floor.
- **Payment System:** Integrated SSLCommerz payment gateway for room bookings with cash or online payment options.
- **Invoice Generation:** After successful payment, users can download the invoice in PDF format using the html2pdf package.
- **Sending Email Notification:** After successful payment, users can read an instant email to about booking information using mailtrap.
- **Restaurant Booking:** Users can book a table in the restaurant by entering their name, email, phone number, number of guests, and the desired date/time.
- **Admin Panel:** Admins can view detailed reports of room bookings, transactions, and revenue. Charts such as area charts and line charts are used to show booking and revenue data.
- **Role-Based Permissions:** Admins can manage user roles and permissions using the spatie/laravel-permission package.
- **Data Import/Export:** Admins can import/export data using CSV files with the maatwebsite/excel package.
- **Authentication:** User authentication is handled by Laravel Breeze, and Vue.js is used for the frontend.

## Installation

#### 1. Clone the repository:
   
    git clone https://github.com/Shareiar-shams/HManagement.git

#### 2. Install backend dependencies:

   
    composer install

#### 3. Install frontend dependencies:
    Navigate to the frontend directory and run:
    
    npm install


#### 4. Configure environment:
    Copy .env.example to .env and update the environment variables such as database credentials, payment gateway settings, etc.
    
    cp .env.example .env
    
#### Generate application key:
    php artisan key:generate

#### 5. Migrate the database:
    php artisan migrate

#### 6. Run the backend:
    php artisan serve
#### 7. Run the frontend:
    npm run dev

## Usage

    - Frontend: The Vue.js frontend interacts with the Laravel backend through API endpoints.
    - Admin Panel: Admin users can log in and manage the hotel data such as room management, transaction reports, and revenue charts.

### Admin Panel Access
    your_domain/admin/login (in local use localhost::8000/admin/login)
    
    To access the Admin Panel, visit the following URL:

#### Login Credentials:
    - **Email:** admin@example.com
    - **Password:** shareiar


## Contribution
Feel free to contribute to this project by submitting issues or pull requests. Follow these steps:
1. Fork the repository.
2. Create a new branch:
   ```bash
   git checkout -b feature-name
   ```
3. Commit changes and push to the branch.
4. Open a pull request.


---

For any queries or support, feel free to contact [islamshareiar@gmail.com].
