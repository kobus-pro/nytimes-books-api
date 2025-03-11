<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;

class ApiAuthenticationException extends ApiException
{
    /**
     * @param string $message
     * @param int $statusCode
     * @param array|null $responseData
     * @param Throwable|null $previous
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
     * @return string
     */
    public function getUserMessage(): string
    {
        return 'Unable to access NY Times Books API. Authentication failed.';
    }

    /**
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