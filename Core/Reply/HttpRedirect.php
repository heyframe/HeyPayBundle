<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Core\Reply;

class HttpRedirect extends HttpResponse
{
    /**
     * @param string[] $headers
     */
    public function __construct(protected string $url, int $statusCode = 302, array $headers = [])
    {
        $headers['Location'] = $url;

        parent::__construct($this->prepareContent($url), $statusCode, $headers);
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    protected function prepareContent($url): string
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
        }

        return \sprintf('<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="refresh" content="1;url=%1$s" />

        <title>Redirecting to %1$s</title>
    </head>
    <body>
        Redirecting to %1$s.
    </body>
</html>', htmlspecialchars((string) $url, \ENT_QUOTES, 'UTF-8'));
    }
}
