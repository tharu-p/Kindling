# Kindling - Community Event Platform

Kindling is a web application designed to combat social isolation by connecting people through local events. It allows users to discover nearby events, create their own events, and foster community engagement.

## Features

* **Event Discovery:** Browse a list of upcoming community events.
* **Location-Based Search:** Find events near your current location using the Google Maps Places API.
* **Event Creation:** Easily create and publish your own events.
* **Multilingual Support:** Supports English, Spanish, Simplified Chinese, Hindi, and Arabic.
* **User Authentication:** User registration and login functionality.
* **Automatic Event Deletion:** Events are automatically deleted after their scheduled time.

## Technologies Used

* **Front-end:** HTML, CSS, JavaScript
* **Back-end:** PHP
* **Database:** MySQL
* **APIs:** Google Maps Places API
* **Version Control:** Git

## Setup Instructions

1.  **Clone the Repository:**
    ```bash
    git clone [https://github.com/your-username/Kindling-CNLC.git](https://github.com/your-username/Kindling-CNLC.git)
    ```
2.  **Install XAMPP:**
    * Download and install XAMPP from [apachefriends.org](https://www.apachefriends.org/).
3.  **Place Project Files:**
    * Copy the contents of the cloned repository into your XAMPP's `htdocs` directory.
4.  **Create Database:**
    * Open phpMyAdmin (or your MySQL client).
    * Create a new database (ex. `kindling`).
    * Import the `database.sql` file (provided separately or create your own tables).
5.  **Configure Database Connection:**
    * Open the `db_connect.php` file and update the database credentials.
6.  **Enable Google Maps API:**
    * Create a Google Cloud Platform project and enable the Places API and Maps JavaScript API.
    * Replace the placeholder API key in your HTML files with your actual API key.
7.  **Run the Application:**
    * Start the Apache and MySQL services in your XAMPP control panel.
    * Open your web browser and navigate to `http://localhost/Kindling-CNLC/home.php`.

## Database Setup

1.  **Create Database:**
    * Create a database called "Kindling"
2.  **Import Database:**
    * Import the `database.sql` file (provided in the repository) into your database.
3.  **Table Structure:**
    * The database contains two tables: `events` and `users`.
4.  **Events Table:**
    * `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
    * `title` (VARCHAR)
    * `description` (TEXT)
    * `date` (DATE)
    * `time` (TIME)
    * `location` (VARCHAR)
    * `latitude` (DECIMAL)
    * `longitude` (DECIMAL)
    * `event_datetime` (TIMESTAMP)
5.  **Users Table:**
    * `id` (INT, AUTO_INCREMENT, PRIMARY KEY)
    * `username` (VARCHAR, UNIQUE)
    * `password` (VARCHAR)

## Contact

* Your Name: Tharuksith
* Email: tharuksith.p@gmail.com
* GitHub: https://github.com/Wisarc
