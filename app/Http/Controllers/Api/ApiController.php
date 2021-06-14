<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Return generic json response with the given data.
     *
     * @param $data
     * @param int $statusCode
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $statusCode = 200, $message = '', $headers = [])
    {
        $newData = [];

        // Check for response without transformer
        if (!isset($data['data'])) {
            $newData['data'] = $data;
        } else {
            $newData = $data;
        }

        $newData['success'] = [
            'message' => $message
        ];

        return response()->json($newData, $statusCode, $headers);
    }

    /**
     * Respond with success
     *
     * @param array $data
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($data, $message = '')
    {
        return $this->respond($data, 200, $message);
    }

    /**
     * Respond with created.
     *
     * @param array $data
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated($data, $message = '')
    {
        return $this->respond($data, 201, $message);
    }

    /**
     * Respond with no content.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNoContent()
    {
        return $this->respond(null, 204);
    }

    /**
     * Respond with error.
     *
     * @param string $message
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondError($message, $statusCode)
    {
        return response()->json(['errors' => $message], $statusCode);
    }

    /**
     * Respond with error and data.
     *
     * @param array $data
     * @param string $errorMessage
     * @param int $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondErrorWithData($data, $errorMessage, $statusCode)
    {
        return response()->json(['errors' => $errorMessage, 'data' => $data], $statusCode);
    }

    /**
     * Respond with error and message
     *
     * @param $errorMessage  array   an array of errors
     * @param $message       string  a message
     * @param $statusCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondErrorWithMessage(array $errors, string $message, int $statusCode)
    {
        return response()->json(['errors' => $errors, 'message' => $message], $statusCode);
    }

    /**
     * Respond with unauthorized.
     *
     * @param string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }

    /**
     * Respond with forbidden.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondForbidden($message = 'You do not have access to this resource')
    {
        return $this->respondError($message, 403);
    }

    /**
     * Respond with not found.
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }

    /**
     * Respond with failed login.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondFailedLogin()
    {
        return $this->respond([
            'errors' => [
                'email or password' => 'is invalid',
            ]
        ], 422);
    }
}