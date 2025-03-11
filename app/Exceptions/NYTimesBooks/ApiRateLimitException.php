<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;

class ApiRateLimitException extends ApiException
{
    /**
     * @var int|null
     */
    protected ?int $retryAfter = null;

    /**
     * @param string $message
     * @param int|null $statusCode
     * @param array|null $responseData
     * @param Throwable|null $previous
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
     * @return int|null
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }

    /**
     * @return bool
     */
    public function hasRetryAfter(): bool
    {
        return $this->retryAfter !== null;
    }
    
    /**
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