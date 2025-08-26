# API Health Monitor

API Health Monitor is a Laravel application for automated monitoring of HTTP APIs and web services. It tracks uptime, latency, and errors, manages incidents, and provides secure REST endpoints and a dashboard for real-time status.
## Features
## Installation & Setup

1. **Clone the repository**
	```sh
	git clone https://github.com/sudo-init-do/api-health-monitor.git
	cd api-health-monitor
	```
2. **Install dependencies**
	```sh
	composer install
	```
3. **Configure environment**
	```sh
	cp .env.example .env
	php artisan key:generate
	# Edit .env and set HEALTH_API_KEY
	```
4. **Database setup**
	```sh
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed # optional
	```
5. **Start the application**
	```sh
	php artisan serve
	```
	
# API Health Monitor

API Health Monitor is a Laravel application for automated monitoring of HTTP APIs and web services. It provides service CRUD, scheduled and queued health checks, incident tracking, Slack alerts, and a secure dashboard. Designed for DevOps teams and SaaS providers who need reliable, extensible API health reporting and incident management.

## Features
- Service CRUD (create, read, update, delete)
- Queued health checks (background jobs)
- Scheduler for periodic checks (cron-based)
- Incident tracking and resolution
- Slack alert integration (optional)
- API key middleware for endpoint protection
- Dashboard view for service status

## Installation & Setup
1. **Clone the repository**
	```sh
	git clone https://github.com/sudo-init-do/api-health-monitor.git
	cd api-health-monitor
	```
2. **Install dependencies**
	```sh
	composer install
	```
3. **Configure environment**
	```sh
	cp .env.example .env
	php artisan key:generate
	# Edit .env and set HEALTH_API_KEY, ALERT_SLACK_WEBHOOK, etc.
	```
4. **Database setup**
	```sh
	touch database/database.sqlite
	php artisan migrate
	php artisan db:seed # optional
	```
5. **Run the application**
	```sh
	php artisan serve
	```
6. **Start background workers**
	```sh
	php artisan queue:work
	php artisan schedule:work
	```

## Usage Examples
All API endpoints require the `X-API-Key` header.

**List services**
```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services
```

**Create a service**
```sh
curl -X POST -H "X-API-Key: your_key" -H "Content-Type: application/json" \
  -d '{"name":"Demo API","method":"GET","url":"https://example.com/health","expected_status":200,"max_latency_ms":1000,"cron":"* * * * *","enabled":true}' \
  http://localhost:8000/api/services
```

**Trigger health check**
```sh
curl -X POST -H "X-API-Key: your_key" http://localhost:8000/api/services/1/check
```

**List checks**
```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1/checks
```

**List incidents**
```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1/incidents
```

## Environment Variables

- `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`: Laravel app settings
- `DB_CONNECTION`, `DB_DATABASE`: Database config (default: SQLite)
- `HEALTH_API_KEY`: API key for endpoint protection
- `ALERT_SLACK_WEBHOOK`: Slack webhook for incident alerts
- `QUEUE_CONNECTION`: Queue driver (default: database)
- `CACHE_STORE`: Cache driver (default: database)

See `.env.example` for all options.

## Background Workers

- **Queue Worker**: Processes health check jobs
  ```sh
  php artisan queue:work
  ```
- **Scheduler**: Dispatches due checks based on cron expressions
  ```sh
  php artisan schedule:work
  # Or manually:
  php artisan health:dispatch
  ```

## Testing & CI

- Run all tests:
  ```sh
  php artisan test
  ```
- Continuous Integration: GitHub Actions workflow included for automated testing on push and PR.

## Roadmap / Possible Improvements
- Add more notification channels (email, SMS)
- Real-time dashboard updates
- User authentication and roles
- Service dependency mapping
- Advanced incident analytics
- Distributed/multi-region checks

## License

MIT License. See `LICENSE` file.

## Usage Examples

All API endpoints require the `X-API-Key` header.

**List services**
```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services
```

**Create a service**
```sh
curl -X POST -H "X-API-Key: your_key" -H "Content-Type: application/json" \
  -d '{"name":"Demo API","method":"GET","url":"https://example.com/health","expected_status":200,"max_latency_ms":1000,"cron":"* * * * *","enabled":true}' \
  http://localhost:8000/api/services
```

**Trigger health check**
```sh
curl -X POST -H "X-API-Key: your_key" http://localhost:8000/api/services/1/check
```

**List checks & incidents**
```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1/checks
curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1/incidents
```

## Environment Variables

- `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`: Laravel settings
- `DB_CONNECTION`, `DB_DATABASE`: Database config (default: SQLite)
- `HEALTH_API_KEY`: API key for endpoints
- `ALERT_SLACK_WEBHOOK`: Slack webhook for alerts
- `QUEUE_CONNECTION`: Queue driver
- `CACHE_STORE`: Cache driver

See `.env.example` for all options.

## Running Background Workers

- **Queue worker**
  ```sh
  php artisan queue:work
  ```
- **Scheduler**
  ```sh
  php artisan schedule:work
  # Or manually:
  php artisan health:dispatch
  ```

## Testing

Run all tests:
```sh
php artisan test
```
Tests are in `tests/Feature` and `tests/Unit`.

## Roadmap / Possible Improvements

- Add more notification channels (email, SMS)
- Real-time dashboard updates
- User authentication and roles
- Service dependency mapping
- Advanced incident analytics
- Distributed/multi-region checks

## License

MIT License. See `LICENSE` file.
3. Configure environment:
	```sh
	cp .env.example .env
4. Database setup:
	```sh
	touch database/database.sqlite
5. Start the application:
	```sh
	php artisan serve
## Usage Examples
All API endpoints require the `X-API-Key` header.
```sh
**List services**
```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services
**Create a service**
```sh
curl -X POST -H "X-API-Key: your_key" -H "Content-Type: application/json" \
**Trigger health check**
```sh
curl -X POST -H "X-API-Key: your_key" http://localhost:8000/api/services/1/check
## Environment Variables
- `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`: Laravel settings
- `DB_CONNECTION`, `DB_DATABASE`: Database config (default: SQLite)
## Running Background Workers
- Queue worker:
	```sh
	php artisan queue:work
## Testing
Run all tests:
```sh
## Roadmap / Possible Improvements
- Add more notification channels (email, SMS)
- Real-time dashboard updates
## License
MIT License. See `LICENSE` file.
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:


Laravel is accessible, powerful, and provides tools required for large, robust applications.

# API Health Monitor

API Health Monitor is a Laravel-based application designed to automate the monitoring of HTTP APIs and web services. It provides a robust platform for tracking service uptime, latency, and error rates, with automated incident management and alerting capabilities. The system is suitable for DevOps teams, SaaS providers, and anyone needing reliable API health checks and reporting.

## How It Works

1. **Service Registration**: Users register APIs or web services to be monitored, specifying details such as HTTP method, URL, expected status code, latency threshold, and a cron schedule for checks.
2. **Automated Checks**: The system dispatches health checks at scheduled intervals or on demand. Each check records status, latency, HTTP response, and errors.
3. **Incident Management**: Failed checks automatically open incidents, tracking downtime and errors. Incidents are resolved when subsequent checks pass.
4. **API & Dashboard**: All data is accessible via a REST API (protected by API key) and a dashboard view for quick status overview.
5. **Alerting**: Optional Slack integration for real-time incident notifications.
6. **Background Processing**: Health checks and incident management run as queued jobs for scalability and reliability.

## Features

- Service CRUD (create, read, update, delete)
- Automated and manual health checks
- Incident tracking and resolution
- API key-protected REST endpoints
- Slack alert integration
- Dashboard view for service status
- Background job processing and scheduling
- Pagination for checks/incidents
- Extensible configuration

## Installation & Setup

1. **Clone the repository**
	 ```sh
	 git clone https://github.com/sudo-init-do/api-health-monitor.git
	 cd api-health-monitor
	 ```
2. **Install dependencies**
	 ```sh
	 composer install
	 ```
3. **Configure environment**
	 - Copy `.env.example` to `.env` and set required values:
		 ```sh
		 cp .env.example .env
		 ```
	 - Generate an application key:
		 ```sh
		 php artisan key:generate
		 ```
	 - Set `HEALTH_API_KEY` in `.env` for API protection.
4. **Database setup**
	 - Ensure `DB_CONNECTION=sqlite` and create the database file:
		 ```sh
		 touch database/database.sqlite
		 ```
	 - Run migrations:
		 ```sh
		 php artisan migrate
		 ```
	 - (Optional) Seed demo data:
		 ```sh
		 php artisan db:seed
		 ```
5. **Start the application**
	 ```sh
	 php artisan serve
	 ```

## API Usage Examples

All API endpoints require the `X-API-Key` header:
```
X-API-Key: <your_HEALTH_API_KEY>
```

### Service CRUD

- **List services**
	```sh
	curl -H "X-API-Key: your_key" http://localhost:8000/api/services
	```
- **Create a service**
	```sh
	curl -X POST -H "X-API-Key: your_key" -H "Content-Type: application/json" \
		-d '{"name":"Demo API","method":"GET","url":"https://example.com/health","expected_status":200,"max_latency_ms":1000,"cron":"* * * * *","enabled":true}' \
		http://localhost:8000/api/services
	```
- **Show service details**
	```sh
	curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1
	```
- **Update a service**
	```sh
	curl -X PUT -H "X-API-Key: your_key" -H "Content-Type: application/json" \
		-d '{"enabled":false}' \
		http://localhost:8000/api/services/1
	```
- **Delete a service**
	```sh
	curl -X DELETE -H "X-API-Key: your_key" http://localhost:8000/api/services/1
	```

### Trigger Health Check

```sh
curl -X POST -H "X-API-Key: your_key" http://localhost:8000/api/services/1/check
```

### List Checks & Incidents

```sh
curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1/checks
curl -H "X-API-Key: your_key" http://localhost:8000/api/services/1/incidents
```

## Environment Variables

Key variables in `.env`:

- `APP_NAME`, `APP_ENV`, `APP_KEY`, `APP_URL`: Standard Laravel settings.
- `DB_CONNECTION`, `DB_DATABASE`: Database configuration (default: SQLite).
- `HEALTH_API_KEY`: API key for securing endpoints.
- `ALERT_SLACK_WEBHOOK`: Slack webhook for incident notifications.
- `QUEUE_CONNECTION`: Queue driver (default: database).
- `CACHE_STORE`: Cache driver (default: database).

See `.env.example` for all options.

## Running Background Workers

- **Queue Worker**: Processes health check jobs.
	```sh
	php artisan queue:work
	```
- **Scheduler**: Dispatches due checks based on cron expressions.
	```sh
	php artisan schedule:work
	```
	Or run the command manually:
	```sh
	php artisan health:dispatch
	```

## Testing

- **Run all tests**
	```sh
	php artisan test
	```
- Feature and unit tests are located in `tests/Feature` and `tests/Unit`.

## Roadmap / Possible Improvements

- Add support for additional notification channels (email, SMS)
- Enhance dashboard with real-time updates and charts
- Implement user authentication and roles
- Add service dependency mapping and impact analysis
- Improve incident analytics and reporting
- Support for distributed checks and multi-region monitoring

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
