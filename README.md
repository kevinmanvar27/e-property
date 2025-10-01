# E-Property Management System

## Overview
The E-Property Management System is a comprehensive solution for managing various types of properties including land, plots, shads, shops, and houses. This system provides administrators with tools to manage properties, users, locations, and master data.

## Features
- Property Management (Land/Jamin, Plot, Shad, Shop, House)
- User Management (Admins and Regular Users)
- Location Management (Countries, States, Districts, Cities)
- Master Data Management (Amenities, Land Types)
- Settings Management
- Role-based Access Control
- Permission-based Access Control

## Permission System
This system includes a comprehensive permission system that allows administrators to assign specific CRUD (Create, Read, Update, Delete) permissions to users for each module.

### Modules with Permissions
- Land / Jamin
- Plot
- Shad
- Shop
- House
- Amenities
- Land Types
- Countries
- States
- Districts
- Cities/Talukas
- Settings
- Management Users
- Regular Users

### Actions
Each module supports the following actions:
- View
- Create
- Update
- Delete

For detailed information about the permission system, see [PERMISSIONS.md](PERMISSIONS.md).

## Installation
1. Clone the repository
2. Run `composer install`
3. Run `npm install`
4. Copy `.env.example` to `.env` and configure your database settings
5. Run `php artisan key:generate`
6. Run `php artisan migrate`
7. Run `php artisan db:seed`
8. Run `npm run dev` to compile assets

## Usage
1. Access the admin panel at `/admin/login`
2. Login with the default admin credentials
3. Navigate through the various modules to manage properties, users, and settings

## Testing
Run tests with `php artisan test`

## License
This project is proprietary and confidential. Unauthorized copying or distribution is prohibited.