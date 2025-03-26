# ABC Fitness API Testing Guide

This guide provides cURL commands for testing the ABC Fitness API endpoints. You can import these commands into Postman or use them directly in your terminal.

## Base URL

```
http://localhost:8000
```

## Welcome Endpoint

### Get Welcome Message

```bash
curl -X GET http://localhost:8000/
```

Expected Response:
```json
{"message":"Welcome to ABC Fitness API"}
```

## Classes Endpoints

### Create a New Class (Success)

```bash
curl -X POST http://localhost:8000/api/classes \
  -H "Content-Type: application/json" \
  -d '{
    "class_name": "Yoga Basics",
    "start_date": "2024-01-20 09:00:00",
    "end_date": "2024-01-20 10:00:00",
    "capacity": 20
  }'
```

Expected Response:
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

### Create a New Class (Missing Fields)

```bash
curl -X POST http://localhost:8000/api/classes \
  -H "Content-Type: application/json" \
  -d '{
    "class_name": "Yoga Basics"
  }'
```

Expected Response:
```json
{
    "error": "Missing required field: start_date"
}
```

## Bookings Endpoints

### Create a New Booking (Success)

```bash
curl -X POST http://localhost:8000/api/bookings \
  -H "Content-Type: application/json" \
  -d '{
    "class_id": 1,
    "member_name": "John Doe"
  }'
```

Expected Response:
```json
{
    "message": "Booking created successfully",
    "data": {
        "class_id": 1,
        "member_name": "John Doe"
    }
}
```

### Create a New Booking (Missing Fields)

```bash
curl -X POST http://localhost:8000/api/bookings \
  -H "Content-Type: application/json" \
  -d '{
    "class_id": 1
  }'
```

Expected Response:
```json
{
    "error": "Missing required field: member_name"
}
```

## Testing Tips

1. Make sure the server is running on `localhost:8000` before testing
2. Use the correct Content-Type header for POST requests
3. Test both success and error scenarios
4. Check the response status codes and messages