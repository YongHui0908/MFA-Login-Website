Implementation of Multi-Factor Authentication to Enhance the Security of an Online University Examination

This project is designed to enhance the security of online university examinations by implementing a multi-factor authentication (MFA) system. The system combines traditional username/password authentication with facial recognition verification using AWS Rekognition to ensure that only authorized users access the examination platform.

Table of Contents:
- Overview
- Features
- Technologies Used
- Installation
- Usage
- Project Structure
- Contributing
- Acknowledgments

Overview

The rapid shift to online education during the COVID-19 pandemic exposed the vulnerabilities of single-factor authentication methods in ensuring academic integrity. This project addresses these issues by integrating a robust MFA system that leverages facial recognition technology. The system includes secure registration, login with face verification, an examination dashboard for users, and an admin panel for managing exam modules and monitoring user activity. Data protection is enforced through AES encryption and secure key management via environment variables.

Features
- Secure User Registration: Encrypts sensitive data and captures facial data for verification.
- Multi-Factor Authentication (MFA): Combines password-based login with AWS Rekognition for facial verification.
- Examination Dashboard: Allows users to access and manage exam modules.
- Admin Panel: Offers functionalities such as managing exam modules, viewing user accounts, and generating attendance reports (PDF/CSV).
- Data Protection: Implements AES encryption and secure key management with Dotenv.
- User Profile Management: Enables users and admins to view and edit their profiles securely.

Technologies Used
Frontend
- HTML5, CSS3, JavaScript
- Bootstrap for responsive design
- SweetAlert2 for interactive alerts
Backend
- PHP for server-side scripting
- MySQL for database management
- AWS Rekognition for facial recognition verification
- Dotenv for secure environment variable management
Tools & Resources
- WAMP Server for local development
- Visual Studio Code as the primary IDE
- Git for version control
- Draw.io for creating system diagrams

Installation
1. Clone the Repository:
bash
git clone https://github.com/yourusername/your-repository-name.git
cd your-repository-name

2. Install Dependencies
Ensure you have Composer installed and run:
bash
composer install

3. Configure Environment Variables
Create a .env file in the project root and add your configuration:
bash
AWS_REGION=us-east-1
AWS_ACCESS_KEY_ID=your_aws_access_key
AWS_SECRET_ACCESS_KEY=your_aws_secret_key
ENCRYPTION_KEY=your_encryption_key
SIMILARITY_THRESHOLD=90

4. Set Up the Database
Import the provided SQL schema into your MySQL database.

5. Configure Web Server
Use WAMP Server or your preferred environment to serve the project files.

Usage
- User Registration & Login: Users can register an account and log in using multi-factor authentication.
- Face Recognition: During login, a webcam will capture the user's face for verification.
- Dashboard & Admin Panel: Navigate to the user examination dashboard or admin panel to access respective functionalities.

Project Structure
├── assets/             # Images, logos, and static resources

├── config.php          # Database configuration file

├── vendor/             # Composer dependencies

├── .env                # Environment variables (not committed to Git)

├── .gitignore          # Files and directories to ignore

├── admin_dashboard.php # Admin panel for managing exams and user data

├── registration.php    # User registration page

├── login.php           # User login page

├── face_verification.php  # Face recognition verification page

└── README.md           # This file

Contributing
Contributions are welcome! Please fork the repository and submit your pull requests for any improvements or bug fixes.

Acknowledgments
- AWS Rekognition
- Bootstrap
- SweetAlert2
- Dotenv
