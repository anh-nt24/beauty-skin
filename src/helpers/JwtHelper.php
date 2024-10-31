<?php
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JwtHelper {
    private static $secretKey = 'beautyskin@2024beautyskin@2024beautyskin@2024beautyskin@2024!@#';
    private static $algorithm = 'HS256';

    public static function createToken($account) {
        $payload = [
            'iss' => 'localhost', // issuer
            'iat' => time(), // issued at
            'exp' => time() + (60 * 60 *24 * 30), // expires in 1 month
            'data' => $account
        ];
        return JWT::encode($payload, self::$secretKey, self::$algorithm);
    }

    public static function parseJWT($token) {
        try {
            $decoded = JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function validateToken($token) {
        try {
            JWT::decode($token, new Key(self::$secretKey, self::$algorithm));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
