VoyaBlog API
VoyaBlog is a simple blog and post management API developed using Laravel 11 and MySQL. It allows users to create, read, update, and delete blogs and posts, as well as interact with posts through likes and comments.

Features
Blogs: Create, view, update, and delete blogs.
Posts: Create, view, update, and delete posts under a blog.
Comments: Add and remove comments on posts.
Likes: Like posts.

Requirements
PHP 8.2 or above
Composer
MySQL
Postman (for API testing)
Installation
Clone the Repository


git clone https://github.com/yourusername/voyablog.git
cd voyablog
Install Dependencies

Run the following command to install the required dependencies:


composer install
Set Up Environment Variables

Copy the .env.example file to .env and set up your database connection and other configurations.

cp .env.example .env
Update the .env file with your database credentials and other necessary configurations.


Run Migrations

Set up the database and run the migrations:

php artisan migrate
Run the Application

Start the Laravel development server:
php artisan serve
The application will be available at http://localhost:8000.

API Documentation
The API can be tested using Postman. A Postman collection is provided in the project repository. Import the collection into Postman to see the available endpoints and their usage.

Authentication
API requests require an Authorization header with the value vg@123. This is a placeholder for demonstration purposes and should be replaced with proper authentication in a production environment.



Contact
For any questions or issues, please contact kelejoe79@gmail.com