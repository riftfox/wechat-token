<?php

namespace Riftfox\Wechat\Token;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Log\LoggerInterface;
use Riftfox\Wechat\Application\ApplicationInterface;
use Riftfox\Wechat\Exception\ExceptionFactoryInterface;

abstract class TokenProvider implements TokenProviderInterface
{
    private ClientInterface $client;
    private TokenFactoryInterface $tokenFactory;
    private ExceptionFactoryInterface $exceptionFactory;
    private LoggerInterface $logger;
    protected string $cacheKey;

    public function __construct(ClientInterface           $client,
                                TokenFactoryInterface     $tokenFactory,
                                ExceptionFactoryInterface $exceptionFactory)
    {
        $this->client = $client;
        $this->tokenFactory = $tokenFactory;
        $this->exceptionFactory = $exceptionFactory;
    }

    /**
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    public function token(ApplicationInterface $application, bool $forceRefresh = false): TokenInterface
    {
        $json = $this->client->sendRequest($this->getRequest($application, $forceRefresh))->getBody()->getContents();
        if (isset($this->logger)) {
            $this->logger->debug("Response data from '{$json}' is already in use");
        }
        $data = json_decode($json, true);
        if (isset($data['errcode']) && $data['errcode'] !== 0) {
            throw $this->exceptionFactory->createException($data['errmsg'], $data['errcode']);
        }
        return $this->tokenFactory->createTokenFormArray($data);
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    public abstract function getRequest(ApplicationInterface $application, bool $forceRefresh = false): RequestInterface;

}