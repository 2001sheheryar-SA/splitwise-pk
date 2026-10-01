<?php

namespace App\Providers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

/**
 * Registers a consistent, reusable JSON response structure that can be
 * called from any controller as response()->success(...) / response()->error(...).
 */
class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Response::macro('success', function (
            string $message = 'Request was successful.',
            mixed $data = null,
            int $status = 200,
            array $meta = []
        ): JsonResponse {
            $payload = [
                'success' => true,
                'message' => $message,
                'data' => $data,
            ];

            if (! empty($meta)) {
                $payload['meta'] = $meta;
            }

            return response()->json($payload, $status);
        });

        Response::macro('error', function (
            string $message = 'Something went wrong.',
            int $status = 400,
            mixed $errors = null
        ): JsonResponse {
            $payload = [
                'success' => false,
                'message' => $message,
                'data' => null,
            ];

            if (! is_null($errors)) {
                $payload['errors'] = $errors;
            }

            return response()->json($payload, $status);
        });
    }
}
