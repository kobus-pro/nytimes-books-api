<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;

class ApiAuthenticationException extends ApiException
{
    /**
     * Create a new API authentication exception
     *
     * @param string $message Error message
     * @param int $statusCode HTTP status code
     * @param array|null $responseData Response data from the API
     * @param Throwable|null $previous Previous exception if applicable
     */
    public function __construct(
        string $message = 'Authentication failed with NY Times API',
        int $statusCode = 401,
        ?array $responseData = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $responseData, $previous);
    }

    /**
     * Get a user-friendly error message
     *
     * @return string
     */
    public function getUserMessage(): string
    {
        return 'Unable to access NY Times Books API. Authentication failed.';
    }

    /**
     * Get troubleshooting information to help resolve the issue
     *
     * @return string
     */
    public function getTroubleshootingInfo(): string
    {
        return "To resolve this issue:\n" .
               "1. Check that your NY Times API key is correct in your .env file\n" .
               "2. Verify the API key has access to the Books API\n" .
               "3. Make sure your API key is active in the NY Times Developer Portal";
    }

    /**
     * Get detailed error information for developers
     * 
     * @return array
     */
    public function getDetailedErrorInfo(): array
    {
        $detailedInfo = parent::getDetailedErrorInfo();
        
        if (isset($this->responseData['fault']['detail'])) {
            $detailedInfo['api_detail'] = $this->responseData['fault']['detail'];
        }
        
        return $detailedInfo;
    }
}