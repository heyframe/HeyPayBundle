<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Reply;

class HttpResponse extends Base
{
    /**
     * @param string[] $headers
     */
    public function __construct(
        protected ?string $content = '',
        protected int $statusCode = 200,
        protected array $headers = []
    ) {
        parent::__construct($statusCode);
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}
