# Modular Architecture for Large-Scale Laravel Projects

This repository contains an architecture I’ve designed based on my personal experience for building large-scale Laravel projects. This project is tailored for a microservice that operates over the HTTP protocol and does not include user-specific functionality. It serves as a foundation for reusable, general-purpose modules.

This project is built using a **modular architecture** specifically designed for **microservice architecture**. It ensures better scalability, maintainability, and separation of concerns in a microservice environment.

## General Modules and Dependencies

The following packages are utilized to support the core functionality of this microservice architecture:

```json
{
    "dedoc/scramble": "^0.11.33",             // API documentation generation
    "grkamil/laravel-telegram-logging": "^1.12", // Telegram-based logging
    "laravel/telescope": "^5.2",              // Debugging and performance monitoring
    "nwidart/laravel-modules": "*",           // Modular structure for Laravel
    "spatie/laravel-query-builder": "^6.3",   // Flexible query building
    "spatie/laravel-translatable": "^6.9",    // Multilingual support
    "stancl/tenancy": "^3.8",                 // Multi-tenancy capabilities
    "phpunit/phpunit": "^11.5"                // Testing framework
}
```

These dependencies provide a robust foundation for building scalable, maintainable, and testable microservices.

## Module-Specific Dependencies

For managing modular components, the following package is used:

```json
{
    "kalnoy/nestedset": "*"                   // Hierarchical data management
}
```

This package enables efficient handling of nested data structures within the modular system.

## Installation

To set up the project, follow these steps:

```bash
git clone <repository-url>
cd <project-folder>
composer install
php artisan migrate
```

📌 **Note:** This architecture is designed specifically for microservices operating over HTTP without user authentication. If you require user management or authentication mechanisms, additional implementation will be needed.

