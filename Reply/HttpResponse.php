<?php declare(strict_types=1);

namespace HeyPay\Bundle\PayBundle\Reply;

use HeyPay\Bundle\PayBundle\Core\Reply\Base;
use Symfony\Component\HttpFoundation\Response;

class HttpResponse extends Base
{
    public function __construct(protected Response $response)
    {
        parent::__construct();
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
