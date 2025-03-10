<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;

class ApiRateLimitException extends ApiException
{
    /**
     * @var int|null The number of seconds until the rate limit resets
     */
    protected ?int $retryAfter = null;

    /**
     * Create a new API rate limit exception instance.
     *
     * @param string $message The exception message
     * @param int|null $statusCode The HTTP status code
     * @param array|null $responseData The response data from the API
     * @param Throwable|null $previous Previous exception if applicable
     */
    public function __construct(
        string $message = 'Rate limit exceeded for NY Times API',
        ?int $statusCode = 429,
        ?array $responseData = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $responseData, $previous);
        
        if (isset($responseData['headers']['retry-after'][0])) {
            $this->retryAfter = (int) $responseData['headers']['retry-after'][0];
        }
    }

    /**
     * Get the number of seconds until the rate limit resets.
     *
     * @return int|null
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }

    /**
     * Check if retry information is available.
     *
     * @return bool
     */
    public function hasRetryAfter(): bool
    {
        return $this->retryAfter !== null;
    }
    
    /**
     * Get a user-friendly error message
     *
     * @return string
     */
    public function getUserMessage(): string
    {
        $message = 'NY Times API rate limit exceeded.';
        
        if ($this->hasRetryAfter()) {
            $message .= " Please try again in {$this->retryAfter} seconds.";
        }
        
        return $message;
    }
    
    /**
     * Get troubleshooting information to help resolve the issue
     *
     * @return string
     */
    public function getTroubleshootingInfo(): string
    {
        return "To resolve this issue:\n" .
               "1. Reduce the frequency of your API requests\n" .
               "2. Consider implementing caching for frequently accessed data\n" .
               "3. Check if your application has any runaway processes making redundant API calls";
    }
    
    /**
     * Get detailed error information for developers
     * 
     * @return array
     */
    public function getDetailedErrorInfo(): array
    {
        $detailedInfo = parent::getDetailedErrorInfo();
        
        if ($this->hasRetryAfter()) {
            $detailedInfo['retry_after'] = $this->retryAfter;
        }
        
        return $detailedInfo;
    }
}