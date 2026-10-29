# PBS Student Management

A web application for managing student records and academic progression at Permata Bangsa School.

## Features

- Role-based access for administrators and teachers
- Student and parent/guardian data management
- Academic-year management and student academic history
- Student promotion to the next academic year
- Student data export to Excel, with selectable fields and class filters
- Search, filtering, and pagination for student and academic lists

## Tech Stack

- PHP 8.2+
- CodeIgniter 4.7
- MySQL / MariaDB
- PhpSpreadsheet

## Requirements

- PHP 8.2 or newer with `intl`, `mbstring`, `mysqli`, and `zip` extensions enabled
- Composer
- MySQL or MariaDB

## Local Setup

1. Clone this repository and enter the project directory.
2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Copy `.env.example` to `.env` and configure the database connection and `app.baseURL`.
4. Create a MySQL database named `student_data` (or update the database name in `.env`).
5. Import a compatible database schema and data backup. **A database dump is not included in this repository.** The current project does not provide a complete set of migrations for creating the entire database from scratch.
6. Start the development server:

   ```bash
   php spark serve --host 127.0.0.1 --port 8081
   ```

7. Open `http://localhost:8081` in your browser.

## Configuration

Keep credentials and environment-specific settings in `.env`. Never commit `.env`, database backups, or real student/guardian data.

## Notes

This project was developed as a practical-work project. No production database, user accounts, or school records are included.
