# NIST19 Admin Panel

## Overview

This is a PHP-based admin panel for managing notices and activities for the NIST19 website. The application provides a clean, responsive interface for administrators to perform CRUD operations on notices and activities, along with basic user management functionality.

## System Architecture

### Frontend Architecture
- **Framework**: Tailwind CSS for styling with responsive design
- **JavaScript**: Vanilla JavaScript for dynamic interactions
- **Icons**: Font Awesome 6.4.0 for consistent iconography
- **Layout**: Fixed sidebar with collapsible functionality
- **Responsive**: Mobile-friendly design with adaptive layouts

### Backend Architecture
- **Language**: PHP 7.4+ with object-oriented patterns
- **Server**: Built-in PHP development server (php -S)
- **Session Management**: Native PHP sessions for authentication
- **File Upload**: Native PHP file handling for image uploads
- **Architecture Pattern**: MVC-like structure with separation of concerns

### Authentication System
- **Method**: Hardcoded credentials (admin@gmail.com / Admin@1)
- **Session-based**: PHP sessions for maintaining login state
- **Protection**: Page-level authentication checks
- **Logout**: Complete session destruction

## Key Components

### Database Layer (`config/database.php`)
- **Connection**: PDO with MySQL
- **Configuration**: Localhost MySQL with default credentials
- **Error Handling**: Exception-based error management
- **Singleton Pattern**: Global database connection function

### Authentication Layer (`config/auth.php`)
- **Session Management**: requireAuth() function for protected pages
- **User Info**: Helper functions for admin name and email
- **Login State**: isLoggedIn() status checking

### Core Modules
1. **Dashboard** (`dashboard.php`) - Statistics and overview
2. **Notices** (`notices.php`) - Notice CRUD operations
3. **Activities** (`activities.php`) - Activity CRUD with image upload
4. **Users** (`users.php`) - User management (incomplete)
5. **Profile** (`profile.php`) - Admin profile management

### Handlers (`handlers/`)
- **AJAX Endpoints**: JSON-based API responses
- **File Upload**: Image processing for activities
- **Status Toggle**: Dynamic status updates
- **Data Validation**: Input sanitization and validation

## Data Flow

### Authentication Flow
1. User accesses any protected page
2. `requireAuth()` checks session status
3. Redirects to login if not authenticated
4. Login validates against hardcoded credentials
5. Sets session variables on successful login

### CRUD Operations
1. **Create**: Form submission → Validation → Database insert → Redirect with message
2. **Read**: Database query → Fetch data → Display in tables/cards
3. **Update**: Pre-populate form → Validation → Database update → Redirect
4. **Delete**: Confirmation modal → Database deletion → Refresh page

### File Upload Flow
1. Image upload via form
2. Validation (file type, size)
3. Unique filename generation
4. Move to uploads directory
5. Store path in database

## External Dependencies

### CDN Resources
- **Tailwind CSS**: `https://cdn.tailwindcss.com`
- **Font Awesome**: `https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css`

### Server Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) or PHP built-in server

### PHP Extensions
- PDO MySQL
- GD (for image processing)
- Session support
- File upload support

## Deployment Strategy

### Development Environment
- **Server**: PHP built-in development server
- **Port**: 5000
- **Document Root**: Current directory
- **Hot Reload**: Manual refresh required

### Production Considerations
- Database credentials should be environment-specific
- Hardcoded admin credentials should be replaced with proper user management
- File upload directory needs proper permissions
- HTTPS should be enforced
- Error reporting should be disabled

### Database Setup
1. Import `schema.sql` to create database structure
2. Default admin user needs password hashing implementation
3. Sample data included for testing

## User Preferences

Preferred communication style: Simple, everyday language.

## Changelog

Changelog:
- June 21, 2025. Initial setup