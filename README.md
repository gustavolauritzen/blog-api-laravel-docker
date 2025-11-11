# Blog API REST - Laravel + Docker

A complete RESTful API for a blog system built with Laravel 11, MySQL, Redis, and Docker. This project demonstrates modern backend development practices, API design, authentication, and containerization.

## Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Getting Started](#getting-started)
- [API Documentation](#api-documentation)
- [Authentication](#authentication)
- [Testing](#testing)
- [Development](#development)

---

## Features

- **RESTful API** - Complete CRUD operations for Posts, Categories, and Tags
- **Authentication** - Token-based authentication using Laravel Sanctum
- **Authorization** - Role-based access control (only post authors can edit/delete)
- **Relationships** - Complex database relationships (One-to-Many, Many-to-Many)
- **Docker** - Fully containerized environment (PHP, Nginx, MySQL, Redis)
- **Validation** - Request validation for all endpoints
- **Seeders** - Sample data for quick testing
- **API Resources** - Structured JSON responses

---

## Tech Stack

| Technology | Version | Purpose |
|------------|---------|---------|
| **Laravel** | 11.x | PHP Framework |
| **PHP** | 8.2 | Backend Language |
| **MySQL** | 8.0 | Database |
| **Redis** | Alpine | Cache & Sessions |
| **Nginx** | Alpine | Web Server |
| **Docker** | Latest | Containerization |
| **Laravel Sanctum** | 4.x | API Authentication |

---

## Project Structure

```
apiRestLaravelDocker/
├── app/
│   ├── Http/Controllers/Api/
│   │   ├── AuthController.php      # Authentication (register, login, logout)
│   │   ├── PostController.php      # Posts CRUD
│   │   ├── CategoryController.php  # Categories CRUD
│   │   └── TagController.php       # Tags CRUD
│   └── Models/
│       ├── User.php                # User model (hasMany posts)
│       ├── Post.php                # Post model (belongsTo user/category, belongsToMany tags)
│       ├── Category.php            # Category model (hasMany posts)
│       └── Tag.php                 # Tag model (belongsToMany posts)
├── database/
│   ├── migrations/                 # Database schema
│   └── seeders/                    # Sample data
├── routes/
│   └── api.php                     # API routes
├── docker/
│   └── nginx/
│       └── default.conf            # Nginx configuration
├── docker-compose.yml              # Docker orchestration
├── Dockerfile                      # PHP custom image
└── .env                            # Environment variables (not in git)
```

---

## Getting Started

### Prerequisites

- Docker & Docker Compose installed
- Git

### Installation

1. **Clone the repository:**
   ```bash
   git clone <your-repo-url>
   cd apiRestLaravelDocker
   ```

2. **Start Docker containers:**
   ```bash
   docker-compose up -d
   ```

3. **Install dependencies (if needed):**
   ```bash
   docker-compose exec app composer install
   ```

4. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

5. **Generate application key:**
   ```bash
   docker-compose exec app php artisan key:generate
   ```

6. **Run migrations and seeders:**
   ```bash
   docker-compose exec app php artisan migrate:fresh --seed
   ```

7. **Access the API:**
   ```
   http://localhost:8000
   ```

### Test Credentials

After running seeders, you can login with:
- **Email:** `john@example.com`
- **Password:** `password`

---

## API Documentation

### Base URL
```
http://localhost:8000/api
```

### Endpoints Overview

| Method | Endpoint | Auth Required | Description |
|--------|----------|---------------|-------------|
| POST | `/register` | No | Register new user |
| POST | `/login` | No | Login and get token |
| POST | `/logout` | Yes | Logout (revoke token) |
| GET | `/me` | Yes | Get authenticated user |
| GET | `/posts` | No | List all posts |
| GET | `/posts/{id}` | No | Get single post |
| POST | `/posts` | Yes | Create post |
| PUT | `/posts/{id}` | Yes | Update post (author only) |
| DELETE | `/posts/{id}` | Yes | Delete post (author only) |
| GET | `/categories` | No | List all categories |
| GET | `/categories/{id}` | No | Get single category |
| POST | `/categories` | Yes | Create category |
| PUT | `/categories/{id}` | Yes | Update category |
| DELETE | `/categories/{id}` | Yes | Delete category |
| GET | `/tags` | No | List all tags |
| GET | `/tags/{id}` | No | Get single tag |
| POST | `/tags` | Yes | Create tag |
| PUT | `/tags/{id}` | Yes | Update tag |
| DELETE | `/tags/{id}` | Yes | Delete tag |

---

## Authentication

This API uses **Bearer Token** authentication via Laravel Sanctum.

### 1. Register a new user

**Request:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "name": "Your Name",
    "email": "your@email.com",
    "password": "yourpassword",
    "password_confirmation": "yourpassword"
  }'
```

**Response:**
```json
{
  "access_token": "1|abcdef123456...",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Your Name",
    "email": "your@email.com"
  }
}
```

### 2. Login

**Request:**
```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password"
  }'
```

**Response:**
```json
{
  "access_token": "2|xyz789...",
  "token_type": "Bearer",
  "user": { ... }
}
```

### 3. Using the token

Include the token in the `Authorization` header for protected routes:

```bash
curl -X GET http://localhost:8000/api/me \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## API Examples

### List all posts

```bash
curl -X GET http://localhost:8000/api/posts \
  -H "Accept: application/json"
```

**Response:**
```json
[
  {
    "id": 1,
    "title": "Getting Started with Laravel 11",
    "slug": "getting-started-with-laravel-11",
    "excerpt": "Learn the basics...",
    "content": "Full content here...",
    "published": true,
    "published_at": "2025-11-04T...",
    "user": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    },
    "category": {
      "id": 2,
      "name": "Programming",
      "slug": "programming"
    },
    "tags": [
      {
        "id": 1,
        "name": "Laravel",
        "slug": "laravel"
      },
      {
        "id": 2,
        "name": "PHP",
        "slug": "php"
      }
    ]
  }
]
```

### Create a new post

**Request:**
```bash
curl -X POST http://localhost:8000/api/posts \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "title": "My New Post",
    "slug": "my-new-post",
    "excerpt": "Short description",
    "content": "Full content of the post",
    "category_id": 1,
    "published": true,
    "tags": [1, 2, 3]
  }'
```

**Response:**
```json
{
  "id": 5,
  "title": "My New Post",
  "slug": "my-new-post",
  "user": { ... },
  "category": { ... },
  "tags": [ ... ]
}
```

### List categories with post count

```bash
curl -X GET http://localhost:8000/api/categories \
  -H "Accept: application/json"
```

**Response:**
```json
[
  {
    "id": 1,
    "name": "Technology",
    "slug": "technology",
    "description": "Articles about technology...",
    "posts_count": 2
  }
]
```

---

## Testing

### View all routes

```bash
docker-compose exec app php artisan route:list --path=api
```

### Access Laravel Tinker (interactive console)

```bash
docker-compose exec app php artisan tinker
```

Example queries in Tinker:
```php
// List all users
App\Models\User::all();

// Find a post with relationships
App\Models\Post::with(['user', 'category', 'tags'])->first();

// Count published posts
App\Models\Post::where('published', true)->count();
```

### Reset database with fresh data

```bash
docker-compose exec app php artisan migrate:fresh --seed
```

---

## Development

### Useful Docker commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f app

# Access container shell
docker-compose exec app bash

# Run artisan commands
docker-compose exec app php artisan [command]

# Access MySQL
docker-compose exec mysql mysql -u laravel -psecret blog_laravel
```

### Project commands

```bash
# Clear cache
docker-compose exec app php artisan cache:clear

# Clear config
docker-compose exec app php artisan config:clear

# Create a new migration
docker-compose exec app php artisan make:migration create_example_table

# Create a new model
docker-compose exec app php artisan make:model Example

# Create a new controller
docker-compose exec app php artisan make:controller Api/ExampleController --api
```

---

## Database Schema

### Users
- id, name, email, password, timestamps

### Categories
- id, name, slug (unique), description (nullable), timestamps

### Tags
- id, name, slug (unique), timestamps

### Posts
- id, user_id (FK), category_id (FK), title, slug (unique), excerpt (nullable), content, image (nullable), published (boolean), published_at (nullable), timestamps

### Post_Tag (pivot)
- id, post_id (FK), tag_id (FK), timestamps

### Relationships
- User **has many** Posts
- Category **has many** Posts
- Post **belongs to** User
- Post **belongs to** Category
- Post **belongs to many** Tags (many-to-many)

---

## Docker Services

| Service | Container Name | Port | Description |
|---------|---------------|------|-------------|
| **app** | blog-app | 9000 | PHP 8.2 FPM |
| **nginx** | blog-nginx | 8000 | Nginx web server |
| **mysql** | blog-mysql | 3306 | MySQL 8.0 database |
| **redis** | blog-redis | 6379 | Redis cache |

---

## Seeded Data

After running `php artisan db:seed`, you'll have:

- **1 User:** john@example.com (password: `password`)
- **5 Categories:** Technology, Programming, Design, Business, Lifestyle
- **10 Tags:** Laravel, PHP, Docker, API, REST, Tutorial, Backend, Database, MySQL, Development
- **4 Posts:** 3 published, 1 draft (with relationships)

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## License

This project is open-source and available under the [MIT License](https://opensource.org/licenses/MIT).

---

## Support

For questions or issues, please open an issue on GitHub.

---

**Built with Laravel 11 + Docker**
