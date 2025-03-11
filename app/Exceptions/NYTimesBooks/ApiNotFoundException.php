<?php

declare(strict_types=1);

namespace App\Exceptions\NYTimesBooks;

use Throwable;

class ApiNotFoundException extends ApiException
{
    /**
     * @var string|null
     */
    protected ?string $errorCode = null;

    /**
     * @param string $message
     * @param ?string $resource
     * @param int|null $statusCode
     * @param array|null $responseData
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = 'Resource not found in NY Times API',
        protected ?string $resource = null,
        ?int $statusCode = 404,
        ?array $responseData = null,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $statusCode, $responseData, $previous);
        
        if ($this->resource === null) {
            if (isset($responseData['url'])) {
                $parts = parse_url($responseData['url']);
                $path = $parts['path'] ?? '';
                $this->resource = trim($path, '/');
            }
            elseif (isset($responseData['fault']['faultstring'])) {
                $faultString = $responseData['fault']['faultstring'];

                if (preg_match('/url:\s+(.+?)(?:\s|$)/', $faultString, $matches)) {
                    $this->resource = trim($matches[1]);
                }
            }
        }
        
        if (isset($responseData['fault']['detail']['errorcode'])) {
            $this->errorCode = $responseData['fault']['detail']['errorcode'];
        }
    }

    /**
     * @return string|null
     */
    public function getResource(): ?string
    {
        return $this->resource;
    }

    /**
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * @return bool
     */
    public function hasResource(): bool
    {
        return $this->resource !== null;
    }
    
    /**
     * @return string
     */
    public function getUserMessage(): string
    {
        $message = 'The requested information could not be found in the NY Times Books API.';
        
        if ($this->hasResource()) {
            $message = "Could not find resource '{$this->resource}' in the NY Times Books API.";
        }
        
        return $message;
    }
    
    /**
     * @return string
     */
    public function getTroubleshootingInfo(): string
    {
        $troubleshooting = "To resolve this issue:\n" .
               "1. Check that you're requesting a valid resource path\n" .
               "2. Verify that the resource identifier (e.g., ISBN, list name) is correct\n" .
               "3. Consult the NY Times Books API documentation to confirm the resource exists";
               
        if ($this->errorCode) {
            $troubleshooting .= "\n\nAPI Error Code: " . $this->errorCode;
        }
        
        return $troubleshooting;
    }
    
    /**
     * @return array
     */
    public function getDetailedErrorInfo(): array
    {
        $detailedInfo = parent::getDetailedErrorInfo();
        
        if ($this->hasResource()) {
            $detailedInfo['resource'] = $this->resource;
        }
        
        if ($this->errorCode) {
            $detailedInfo['error_code'] = $this->errorCode;
        }
        
        if (isset($this->responseData['fault'])) {
            if (isset($this->responseData['fault']['faultstring'])) {
                $detailedInfo['fault_string'] = $this->responseData['fault']['faultstring'];
            }
            
            if (isset($this->responseData['fault']['detail']) && is_array($this->responseData['fault']['detail'])) {
                $detailedInfo['fault_detail'] = $this->responseData['fault']['detail'];
            }
        }
        
        return $detailedInfo;
    }
}