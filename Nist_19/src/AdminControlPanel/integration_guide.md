# NIST19 Admin Panel Frontend Integration Guide

## Overview
This guide explains how to integrate the dynamic content from your admin panel into your existing frontend website.

## Database Connection Setup

### 1. Database Configuration
The admin panel uses PostgreSQL database with the following connection setup in `config/database.php`:

```php
<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    private $pdo;

    public function __construct() {
        // Uses environment variables for PostgreSQL connection
        $this->host = $_ENV['PGHOST'] ?? 'localhost';
        $this->db_name = $_ENV['PGDATABASE'] ?? 'nist19_admin';
        $this->username = $_ENV['PGUSER'] ?? 'postgres';
        $this->password = $_ENV['PGPASSWORD'] ?? '';
        $this->port = $_ENV['PGPORT'] ?? '5432';
    }
    // ... connection logic
}
```

### 2. Database Tables Structure
```sql
-- Notices table
CREATE TABLE notices (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Activities table  
CREATE TABLE activities (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_url TEXT,
    link TEXT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Frontend Integration Options

### Option 1: Direct PHP Include (Recommended)

Replace your static HTML sections with dynamic PHP includes:

#### For Notices Section:
Replace your existing notice HTML with:
```php
<?php include 'path/to/frontend_notices.php'; ?>
```

#### For Activities Section:
Replace your existing activities HTML with:
```php
<?php include 'path/to/frontend_activities.php'; ?>
```

### Option 2: API Integration (For JavaScript/AJAX)

Use the provided API endpoints for dynamic content loading:

#### Notices API:
```javascript
fetch('/api/get_notices.php?limit=10')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update notices container with data.data
            updateNoticesContainer(data.data);
        }
    });
```

#### Activities API:
```javascript
fetch('/api/get_activities.php?limit=6')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update activities container with data.data
            updateActivitiesContainer(data.data);
        }
    });
```

## Files Created and Their Purpose

### 1. `frontend_notices.php`
- **Purpose**: Dynamic notices section that replaces your static HTML
- **Features**: 
  - Pulls active notices from database
  - Includes "Read More" functionality
  - Responsive modal for full notice content
  - Auto-truncates long descriptions
- **Usage**: Include this file where you want notices to appear

### 2. `frontend_activities.php`
- **Purpose**: Dynamic activities section that replaces your static HTML
- **Features**:
  - Displays active activities with images
  - Handles missing images gracefully
  - Links to external URLs when provided
  - Modal for full activity details
- **Usage**: Include this file in your activities section

### 3. `api/get_notices.php`
- **Purpose**: RESTful API endpoint for notices data
- **Parameters**:
  - `limit`: Number of notices to return (default: 10, max: 50)
  - `status`: Filter by status ('active', 'inactive', 'all')
- **Response**: JSON format with notices array
- **Usage**: For AJAX/JavaScript integration

### 4. `api/get_activities.php`
- **Purpose**: RESTful API endpoint for activities data
- **Parameters**:
  - `limit`: Number of activities to return (default: 6, max: 50)
  - `status`: Filter by status ('active', 'inactive', 'all')
- **Response**: JSON format with activities array
- **Usage**: For AJAX/JavaScript integration

### 5. `frontend_demo.php`
- **Purpose**: Live demonstration of integrated content
- **Features**: Shows both notices and activities sections working with real data
- **Usage**: Visit this page to see how the integration looks

## Implementation Steps

### Step 1: Copy Database Configuration
Copy the `config/database.php` file to your main website directory.

### Step 2: Update Your Website Files
Replace your static HTML sections with the dynamic PHP includes:

```php
<!-- Replace your notices HTML with -->
<?php include 'frontend_notices.php'; ?>

<!-- Replace your activities HTML with -->
<?php include 'frontend_activities.php'; ?>
```

### Step 3: Ensure Database Connection
Make sure your website can connect to the same database as the admin panel.

### Step 4: Test the Integration
1. Add/edit notices in the admin panel
2. Add/edit activities in the admin panel
3. Refresh your frontend to see changes immediately

## CRUD Impact on Frontend

### When you perform CRUD operations in admin panel:

#### Adding New Notice:
- Appears immediately on frontend (if status = 'active')
- Shows in notices section ordered by date
- Includes automatic text truncation and "Read More" link

#### Editing Notice:
- Changes reflect immediately on frontend
- Updated content, title, and date display
- Maintains proper formatting and responsive design

#### Deleting Notice:
- Removes from frontend immediately
- No broken links or missing content

#### Adding New Activity:
- Appears immediately in activities section
- Image uploads display properly
- External links work as expected
- Maintains grid layout and responsive design

#### Editing Activity:
- All changes reflect immediately
- Image updates work seamlessly
- Link changes take effect immediately

#### Deleting Activity:
- Removes from frontend grid immediately
- Cleans up uploaded images automatically

## Security Considerations

1. **Input Sanitization**: All user inputs are sanitized using `htmlspecialchars()`
2. **SQL Injection Prevention**: All database queries use prepared statements
3. **File Upload Security**: Image uploads are validated for type and size
4. **Authentication**: Admin panel requires login credentials
5. **CORS Headers**: API endpoints include proper CORS headers for security

## Troubleshooting

### Common Issues:

1. **Database Connection Errors**:
   - Verify environment variables are set correctly
   - Check database credentials and connectivity

2. **Images Not Displaying**:
   - Ensure `uploads/` directory has proper permissions
   - Verify image paths are relative to web root

3. **No Content Showing**:
   - Check if notices/activities have status = 'active'
   - Verify database tables exist and have data

4. **API Not Working**:
   - Check PHP error logs
   - Verify API files are accessible via web browser

## Maintenance

- **Regular Backups**: Backup your database regularly
- **Image Management**: Monitor uploads directory size
- **Performance**: Consider adding caching for high-traffic sites
- **Updates**: Keep admin panel and database schema up to date

## Support

The integration is designed to be seamless and require minimal maintenance. All changes made through the admin panel will automatically reflect on your frontend website in real-time.