<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add body parsing middleware with custom error handling
$app->addBodyParsingMiddleware();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add middleware to validate JSON content type and body
$app->add(function ($request, $handler) {
    $contentType = $request->getHeaderLine('Content-Type');
    
    if ($request->getMethod() === 'POST') {
        // Check content type
        if (strpos($contentType, 'application/json') === false) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode(['error' => 'Content-Type must be application/json']));
            return $response
                ->withStatus(415)
                ->withHeader('Content-Type', 'application/json');
        }
        
        // Validate JSON body
        $contents = $request->getBody()->getContents();
        if (empty($contents)) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode(['error' => 'Request body cannot be empty']));
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }
        
        json_decode($contents);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write(json_encode(['error' => 'Invalid JSON format: ' . json_last_error_msg()]));
            return $response
                ->withStatus(400)
                ->withHeader('Content-Type', 'application/json');
        }
        
        // Rewind the body for later middleware
        $request->getBody()->rewind();
    }
    
    return $handler->handle($request);
});

use App\Storage\MemoryStorage;

// Add routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode(['message' => 'Welcome to ABC Fitness API']));
    return $response->withHeader('Content-Type', 'application/json');
});

// Classes endpoints
$app->post('/api/classes', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    // Validate required fields
    $requiredFields = ['class_name', 'start_date', 'end_date', 'capacity'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response->getBody()->write(json_encode([
                'error' => "Missing required field: {$field}"
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
    
    try {
        $class = MemoryStorage::addClass($data);
        $response->getBody()->write(json_encode([
            'message' => 'Class created successfully',
            'data' => $class
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode([
            'error' => $e->getMessage()
        ]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
});

// Bookings endpoints
$app->post('/api/bookings', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    
    // Validate required fields
    $requiredFields = ['class_id', 'member_name'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response->getBody()->write(json_encode([
                'error' => "Missing required field: {$field}"
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
    
    try {
        $booking = MemoryStorage::addBooking($data);
        $response->getBody()->write(json_encode([
            'message' => 'Booking created successfully',
            'data' => $booking
        ]));
        return $response->withHeader('Content-Type', 'application/json');
    } catch (\Exception $e) {
        $response->getBody()->write(json_encode([
            'error' => $e->getMessage()
        ]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }
});

$app->run();