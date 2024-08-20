<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Ecommerce API",
 *     version="1.0",
 *     description="API documentation for ECOMMERCE website built in laravel."
 * )
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api",
 *     description="Local Development Server"
 * )
 * 
 * @OA\Schema(
 *     schema="UserResource",
 *     type="object",
 *     title="User Resource",
 *     description="User resource response",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-17T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-17T00:00:00Z")
 * )
 * @OA\Schema(
 *     schema="ProductResource",
 *     type="object",
 *     title="Product Resource",
 *     description="Product resource response",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Foo Bar"),
 *     @OA\Property(property="details", type="string", example="my details")
 * )
 */
class SwaggerDefinitions
{
    // This class is for Swagger annotations only, it doesn't need any methods
}
