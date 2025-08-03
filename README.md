# Moski - WordPress with Redis

A production-ready WordPress Docker setup with Redis support for object caching and session management.

## Features

✅ **WordPress with PHP 8.2 and Apache**  
✅ **Redis PHP Extension** - Pre-installed and configured  
✅ **MySQL 8.0 Database**  
✅ **Redis Server** - For caching and session storage  
✅ **OPcache** - Optimized for performance  
✅ **Docker Compose** - Easy deployment  

## Quick Start

1. **Clone and Build**
```bash
git clone <repository-url>
cd moski
docker-compose up -d
```

2. **Access WordPress**
- WordPress: http://localhost:8080
- Test Page: http://localhost:8080/test-setup.php

3. **Verify Redis Installation**
```bash
docker exec moski-wordpress php -m | grep redis
```

## Architecture

- **WordPress Container**: Custom image with Redis extension
- **MySQL Container**: MySQL 8.0 for database
- **Redis Container**: Redis 7 Alpine for caching

## Redis Configuration

The WordPress container includes:
- **PHP Redis Extension**: Installed via PECL
- **Connection**: Available at `redis:6379` within the container network
- **Persistence**: Redis data is persisted in Docker volume

### Testing Redis Connection

```php
$redis = new Redis();
$redis->connect('redis', 6379);
$redis->set('test', 'Hello Redis!');
echo $redis->get('test'); // Outputs: Hello Redis!
```

## Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `WORDPRESS_DB_HOST` | `db:3306` | MySQL host |
| `WORDPRESS_DB_USER` | `wordpress` | Database user |
| `WORDPRESS_DB_PASSWORD` | `wordpress_password` | Database password |
| `WORDPRESS_DB_NAME` | `wordpress` | Database name |

## WordPress Redis Object Cache

To enable Redis object caching in WordPress:

1. Install a Redis object cache plugin like `Redis Object Cache`
2. Or add this to your `wp-config.php`:

```php
define('WP_REDIS_HOST', 'redis');
define('WP_REDIS_PORT', 6379);
define('WP_CACHE', true);
```

## Commands

```bash
# Start services
docker-compose up -d

# View logs
docker-compose logs -f

# Stop services
docker-compose down

# Rebuild WordPress image
docker-compose build wordpress --no-cache

# Access WordPress container
docker exec -it moski-wordpress bash

# Check Redis status
docker exec moski-redis redis-cli ping
```

## Troubleshooting

### Database Connection Issues
- Wait for MySQL to fully initialize (30-60 seconds on first run)
- Check logs: `docker-compose logs db`

### Redis Connection Issues
- Verify Redis is running: `docker-compose ps`
- Test connection: `docker exec moski-wordpress php -r "echo (new Redis())->connect('redis', 6379) ? 'OK' : 'FAIL';"`

### Performance Optimization
- OPcache is pre-configured with optimal settings
- Redis is configured with persistence enabled
- Use Redis for WordPress object caching for best performance

## Development

The `Dockerfile` includes:
- PHP Redis extension via PECL
- OPcache with production settings
- All necessary PHP extensions for WordPress

## Production Notes

- Change default passwords in `docker-compose.yml`
- Use Docker secrets for sensitive data
- Set up proper backup procedures for MySQL and Redis data
- Configure SSL/TLS termination with a reverse proxy