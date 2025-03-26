<?php
namespace App\Storage;

class MemoryStorage {
    private static $classes = [];
    private static $bookings = [];
    private static $classIdCounter = 1;
    private static $bookingIdCounter = 1;

    public static function addClass($classData) {
        $classData['id'] = self::$classIdCounter++;
        $classData['available_spots'] = $classData['capacity'];
        self::$classes[$classData['id']] = $classData;
        return $classData;
    }

    public static function getClass($classId) {
        return self::$classes[$classId] ?? null;
    }

    public static function addBooking($bookingData) {
        $classId = $bookingData['class_id'];
        $class = self::getClass($classId);

        if (!$class) {
            throw new \Exception('Class not found');
        }

        if ($class['available_spots'] <= 0) {
            throw new \Exception('Class is full');
        }

        $bookingData['id'] = self::$bookingIdCounter++;
        $bookingData['booking_date'] = date('Y-m-d H:i:s');
        self::$bookings[$bookingData['id']] = $bookingData;

        // Update available spots
        self::$classes[$classId]['available_spots']--;

        return $bookingData;
    }

    public static function getBooking($bookingId) {
        return self::$bookings[$bookingId] ?? null;
    }
}