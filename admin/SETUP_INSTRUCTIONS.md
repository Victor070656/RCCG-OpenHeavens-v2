# RCCG Open Heavens Parish - Admin Panel Setup

## 📋 Overview
A complete admin panel system for managing the RCCG Open Heavens Parish website.

## 🚀 Setup Instructions

### Step 1: Database Setup
1. Make sure XAMPP/LAMPP MySQL is running
2. Import the database schema:
   ```bash
   mysql -u root -p < database/schema.sql
   ```
   Or manually:
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `oh_church`
   - Import the file: `admin/database/schema.sql`

### Step 2: Configure Database Connection
The database configuration is already set in [admin/config/db.php](admin/config/db.php):
- Host: `localhost`
- Username: `root`
- Password: `` (empty by default)
- Database: `oh_church`

**Update these credentials if your setup is different.**

### Step 3: Access the Admin Panel
1. Navigate to: `http://localhost/oh/admin/sign-in.php`
2. Use default credentials:
   - **Username:** `admin`
   - **Password:** `Admin@123`

## 📁 Project Structure

```
oh/admin/
├── config/
│   ├── db.php          # Database connection
│   └── auth.php        # Authentication & session management
├── database/
│   └── schema.sql      # Database schema
├── sign-in.php         # Login page (✅ Complete)
├── dashboard.php       # Main dashboard (⏳ To be created)
├── events/             # Events management (⏳ To be created)
├── sermons/            # Sermons management (⏳ To be created)
├── members/            # Members management (⏳ To be created)
└── settings/           # Church settings (⏳ To be created)
```

## 🗄️ Database Tables

### 1. `admin_users`
- Stores admin user accounts
- Roles: super_admin, admin, editor
- Default account: admin / Admin@123

### 2. `events`
- Church events management
- Fields: title, description, dates, location, entry type, image

### 3. `sermons`
- Sermon/message management
- Fields: title, pastor, date, category, scripture, media URLs

### 4. `members`
- Church members database
- Fields: personal info, membership type, department

### 5. `church_settings`
- Church information (account numbers, contact info)
- Key-value pairs for easy configuration

### 6. `newsletter_subscriptions`
- Email newsletter subscribers

### 7. `contact_messages`
- Contact form submissions from website

## 🔐 Authentication System

### Features:
- ✅ Plain text password storage (for development)
- ✅ Session-based authentication
- ✅ Role-based access control (super_admin, admin, editor)
- ✅ Remember me functionality
- ✅ Last login tracking

### Helper Functions (auth.php):
- `is_logged_in()` - Check if user is authenticated
- `get_current_admin()` - Get current admin user data
- `require_auth()` - Protect pages (redirect if not logged in)
- `has_role($role)` - Check user permissions
- `require_role($role)` - Protect pages by role

## 🎯 Key Features

### Completed ✅
1. **Database Schema** - Complete structure for church management
2. **Authentication System** - Login, logout, session management
3. **Sign-in Page** - Functional login with validation
4. **Security** - Password hashing, SQL injection protection

### To Be Completed ⏳
1. **Dashboard** - Statistics and overview
2. **Events Management** - CRUD operations for events
3. **Sermons Management** - CRUD operations for sermons
4. **Members Management** - CRUD operations for members
5. **Church Settings** - Manage account numbers and contact info
6. **Navigation** - Update sidebar with church-specific menu items

## 💰 Donation/Giving Page
**Note:** There is NO donation table in the database. The giving page should only display:
- Church bank account number
- Account name
- Bank name
- Instructions for giving

All configured in the `church_settings` table.

## 🔄 Next Steps

### 1. Create Dashboard (dashboard.php)
- Display statistics (total members, upcoming events, recent sermons)
- Quick actions
- Recent activity feed

### 2. Create Events Module
- List all events
- Add new event
- Edit event
- Delete event
- Upload event images

### 3. Create Sermons Module
- List all sermons
- Add new sermon
- Edit sermon
- Delete sermon
- Upload sermon media (audio/video)

### 4. Create Members Module
- List all members
- Add new member
- Edit member details
- Upload member photos
- Filter by department/membership type

### 5. Create Settings Page
- Update church information
- Manage bank account details
- Update contact information
- Logo and branding

## 🛠️ Usage Examples

### Protecting a Page
```php
<?php
require_once 'config/auth.php';
require_auth(); // Requires any logged-in user

// Or require specific role:
require_role('admin'); // Only admins and super_admins
?>
```

### Getting Current User
```php
<?php
$user = get_current_admin();
echo "Welcome, " . $user['full_name'];
?>
```

### Database Query
```php
<?php
require_once 'config/db.php';

// Safe query with prepared statement
$stmt = $conn->prepare("SELECT * FROM events WHERE status = ?");
$stmt->bind_param("s", $status);
$status = 'upcoming';
$stmt->execute();
$result = $stmt->get_result();
?>
```

## 📞 Support
For issues or questions about the admin panel, please contact the development team.

## 🔒 Security Notes
1. Change the default admin password immediately after first login
2. Use strong passwords for all admin accounts
3. **WARNING:** Passwords are stored in plain text - implement proper hashing for production
4. Keep PHP and MySQL updated
5. Enable HTTPS in production
6. Regular database backups

---

**Built for:** RCCG Open Heavens Parish
**Version:** 1.0.0
**Last Updated:** October 10, 2025
