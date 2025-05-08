# ProfRate – Professor Rating System

ProfRate is a web-based platform designed to help students share feedback about professors and make informed academic choices. It supports role-based access for students, professors, and admins, and includes secure registration, dynamic feedback, and a searchable interface.

## Deployment and Code Access
**Local Deployment Website functionalty Video Link **
[https://youtu.be/E8lOpcWm_Cw?si=y5yDtIrI8nFd9cX3](https://youtu.be/E8lOpcWm_Cw?si=y5yDtIrI8nFd9cX3)
**Repository URL:**  
[https://github.com/LazyHusky26/Prof-Rating-Website](https://github.com/LazyHusky26/Prof-Rating-Website)  

This project is currently intended to run locally.

## Steps to Run Locally

1. **Clone the Repository**  
   ```bash
   git clone https://github.com/LazyHusky26/Prof-Rating-Website.git
   cd Prof-Rating-Website
   ```

2. **Set Up Local Server Environment**  
   - Install and run XAMPP or a similar local server stack.  
   - Move the project folder into the `htdocs` directory.  

3. **Set Up the Database**  
   - Launch phpMyAdmin from XAMPP.  
   - Create a database named `profrating`.  
   - Import the `database_schema.sql` file from the project into the `profrating` database.  

4. **Check Database Configuration**  
   Ensure the following settings in `site_database.php`:  
   ```php
   $db_server = "localhost";
   $db_user = "root";
   $db_pass = "";
   $db_name = "profrating";
   ```

5. **Launch the Application**  
   Open a browser and navigate to:  
   ```
   http://localhost/Prof-Rating-Website/landing.html
   ```

## Project Structure Overview

| File / Folder          | Description |
|------------------------|------------|
| `landing.html`         | Main landing page with call-to-action and navigation |
| `login.php`            | Handles login for students, professors, and admin users |
| `register.php`         | Manages student registration with document upload |
| `dashboard.php`        | Routes users to their appropriate dashboards based on role |
| `professor_home.php`   | Professor dashboard |
| `student_home.php`     | Student dashboard |
| `admin_panel.php`      | Admin interface to manage feedback questions and users |
| `logout.php`           | Ends session and logs out the user |
| `search_bar.php`       | Search interface for professors/universities |
| `search_handler.php`   | Backend for AJAX-powered search results |
| `submit_ratings.php`   | Stores ratings submitted by students and prevents duplicates |
| `site_database.php`    | Configuration for database connectivity |
| `uploads/`             | Stores uploaded documents during student registration |
| `database_schema.sql`  | Contains SQL commands to set up required database tables |

## Database Summary

**Database Name:** `profrating`  

### Main Tables

| Table Name           | Purpose |
|----------------------|---------|
| `student_login`      | Stores student credentials and documents |
| `prof_login`         | Stores professor profiles |
| `admin_login`        | Admin user credentials |
| `questions`          | Feedback questions defined by the admin |
| `prof_reviews`       | Stores submitted feedback for professors |
| `prof_avg_ratings`   | Holds average ratings per professor |

**Team Roles and Contributions**

| Name    | Role | Contributions |
|---------|------|--------------|
| Aarnav  | Backend Developer & Integration | Backend logic, database schema, session flow, integration |
| Mahitha | Security & Moderation | Authentication system, file handling, documentation, question design |
| Abhiram | Frontend Developer & Deployment | User interface design, styling, deployment support |
| Shreyaa | Frontend Developer & UI/UX | UI improvements, styling consistency, version control |
| Jotsna  | Database Administrator & Testing | Schema design, question design, testing, documentation |

Notes for Evaluation

- Secure and role-based login for students, professors, and admins.  
- Document-based student verification (PDF uploads).  
- Admin interface to manage feedback questions dynamically.  
- AJAX-based live search functionality for both professors and universities.  
- Students can rate professors once, and updates are reflected in real-time averages.  
- Project has been structured with modular backend logic and responsive frontend design.
