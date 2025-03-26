# ABC Fitness API

ABC Fitness API is a RESTful web service that manages fitness class bookings and scheduling. It provides endpoints for creating and managing fitness classes, as well as handling member bookings.

## Features

- Fitness class management (create, view)
- Class booking system
- Real-time capacity tracking
- Input validation and error handling

## Prerequisites

- PHP 7.4 or higher
- Composer
- Web server (Apache/Nginx)

## Installation

1. Clone the repository:
   ```bash
   git clone [repository-url]
   cd ABCFitNess
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Start the development server:
   ```bash
   php -S localhost:8000 -t public
   ```

## API Documentation

### Base URL
```
http://localhost:8000
```

### Endpoints

#### Welcome
- `GET /`
  - Returns a welcome message
  - Response: `{"message":"Welcome to ABC Fitness API"}`

#### Classes
- `POST /api/classes`
  - Create a new fitness class
  - Request body:
    ```json
    {
        "class_name": "Yoga Basics",
        "start_date": "2024-01-20 09:00:00",
        "end_date": "2024-01-20 10:00:00",
        "capacity": 20
    }
    ```
  - Success Response:
    ```json
    {
        "message": "Class created successfully",
        "data": {
            "class_name": "Yoga Basics",
            "start_date": "2024-01-20 09:00:00",
            "end_date": "2024-01-20 10:00:00",
            "capacity": 20
        }
    }
    ```

#### Bookings
- `POST /api/bookings`
  - Create a new booking
  - Request body:
    ```json
    {
        "class_id": 1,
        "member_name": "John Doe"
    }
    ```
  - Success Response:
    ```json
    {
        "message": "Booking created successfully",
        "data": {
            "class_id": 1,
            "member_name": "John Doe"
        }
    }
    ```

## Error Handling

The API returns appropriate HTTP status codes and error messages:

- 400 Bad Request: Missing or invalid input
- 404 Not Found: Resource not found
- 500 Internal Server Error: Server-side issues

## Testing

Detailed API testing instructions are available in the [postman_collection.md](postman_collection.md) file.

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.