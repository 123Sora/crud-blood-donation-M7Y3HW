CREATE DATABASE blood_donation_db;
USE blood_donation_db;

CREATE TABLE donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    blood_group VARCHAR(3) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    last_donation DATE,
    city VARCHAR(100),
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

/* Insert sample data into donors table */
INSERT INTO donors (id, name, blood_group, phone, last_donation, city, image, created_at, updated_at, deleted_at) VALUES
(1, 'Soun Sokha', 'A+', '123-456-7890', '2025-03-15', 'Phnom Penh', 'soun_sokha.jpg', '2025-04-08 00:09:04', '2025-04-08 01:37:13', '2025-04-08 01:37:13'),
(2, 'Ly Sreynet', 'B-', '987-654-3210', '2025-02-20', 'Siem Reap', 'ly_sreynet.png', '2025-04-08 00:09:04', '2025-04-08 01:48:58', '2025-04-08 01:48:58'),
(3, 'Kim Heang', 'O+', '555-123-4567', '2025-04-01', 'Battambang', 'kim_heang.jpeg', '2025-04-08 00:09:04', '2025-04-08 01:49:00', '2025-04-08 01:49:00');


