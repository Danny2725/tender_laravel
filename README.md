1. Laravel Project Setup Guide with Docker
   Repository

	•	Repository URL: https://github.com/Danny2725/tender_laravel

Prerequisites

	•	Docker and Docker Compose installed on your machine.
	•	Git for cloning the repository.
 Steps to Set Up the Project with Docker

1. Clone the Project from GitHub
git clone https://github.com/Danny2725/tender_laravel
cd tender_laravel
2. Build and Start Containers
•	Run the following command to build and start the containers in detached mode:
    docker-compose up -d
•	Once the containers are running, the app should be accessible at http://localhost.

3. Stopping the Containers
•	When you’re finished, stop the containers with:
docker-compose down
4. run migration
   - user table:
```
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('contractor','supplier') DEFAULT 'supplier',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

- tender table
```

DROP TABLE IF EXISTS `tenders`;
CREATE TABLE `tenders` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `visibility` enum('public','private') DEFAULT 'public',
  `creator_id` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`),
  CONSTRAINT `tenders_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```

- invents table
```
DROP TABLE IF EXISTS `invites`;
CREATE TABLE `invites` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tender_id` int unsigned NOT NULL,
  `supplier_email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tender_id` (`tender_id`),
  CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`tender_id`) REFERENCES `tenders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```
Laravel Overview

Laravel is one of the most popular PHP frameworks, known for its modern structure, ease of use, and extensive built-in features, making it ideal for building complex web applications. Created by Taylor Otwell in 2011, Laravel provides an excellent solution for both small projects and large, scalable applications.

Key Features of Laravel
1.	Eloquent ORM: Laravel includes a powerful ORM called Eloquent, which simplifies database interactions using PHP classes and an expressive syntax. It supports various relationships (e.g., one-to-many, many-to-many) and query building, making database interactions clean and readable.
2.	Blade Templating Engine: Blade is Laravel’s templating engine, allowing flexible layout management with features like template inheritance (@extends, @section, and @yield). Blade also provides directives like @if, @foreach, and more, making it easy to create clean, maintainable HTML views.
3.	Flexible Routing: Laravel offers robust routing, including RESTful routing and route groups. You can define routes with Route::get(), Route::post(), etc., making endpoint management organized and straightforward. Middleware support enables request filtering and additional security without duplicating code.
	4.	Middleware:
Middleware allows you to handle HTTP requests before they reach the controller, such as user authentication and CSRF protection. This keeps your controller code clean and adds security to your application.
	5.	Artisan Command Line Interface (CLI):
Artisan provides a range of commands for quick project management, from creating controllers, models, and migrations to running scheduled jobs or seeding databases. You can also create custom commands tailored to your specific tasks.
	6.	Authentication and Authorization:
Laravel includes a strong authentication system. Commands like php artisan make:auth (in earlier versions) or Laravel Breeze and Jetstream (in recent versions) help you set up user registration/login functionality quickly. Authorization features allow for easy role-based access control to secure your application.
	7.	Job Scheduling and Queues:
Laravel offers job scheduling to automate repetitive tasks like sending emails and cleaning up old data. Queue support lets you handle time-consuming tasks asynchronously, ensuring that your application remains responsive.
	8.	Database Migrations and Seeding:
Migrations help you manage database changes without manually editing tables, making schema versioning easy. Seeding allows you to populate sample data quickly, making development and testing smoother.
	9.	Testing:
Laravel has robust testing support with PHPUnit for unit and integration testing, and Laravel Dusk for browser testing. This makes it suitable for test-driven development (TDD) and helps maintain high code quality.

Why Choose Laravel for Your Project
	1.	Scalability:
Laravel is suitable for both small applications and large-scale projects, thanks to its modular structure and extensive package support. Laravel packages and modules make it easy to scale and extend functionality as needed.
	2.	Ecosystem and Community:
Laravel has a large community and ecosystem with tools like Laravel Nova (for backend management), Laravel Vapor (for serverless deployment), and numerous third-party packages. The strong community provides ample resources, tutorials, and solutions to common challenges.
	3.	Ease of Maintenance:
Laravel’s MVC structure and coding standards (following PSR and SOLID principles) make it easy to maintain and upgrade. Clean, well-organized code leads to improved readability and longevity, making future updates more manageable.
	4.	Strong Security:
Laravel includes built-in security features like CSRF protection, password hashing (using bcrypt and Argon2), and protection against SQL injection and XSS attacks. Authentication and authorization features allow you to secure endpoints effectively, enhancing the overall security of your application.
