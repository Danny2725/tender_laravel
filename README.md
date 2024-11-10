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

