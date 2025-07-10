<?php

namespace Riftfox\Wechat\Token;

use Riftfox\Wechat\Token\TokenInterface;

class Token implements TokenInterface
{
    private string $accessToken;
    private int $expiresIn;

    public function __construct(string $accessToken, int $expiresIn)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
    }
    public function getAccessToken(): string
    {
        // TODO: Implement getAccessToken() method.
        return $this->accessToken;
    }

    public function setAccessToken($accessToken):void
    {
        // TODO: Implement setAccessToken() method.
        $this->accessToken = $accessToken;
    }

    public function getExpiresIn(): int
    {
        // TODO: Implement getExpiresIn() method.
        return $this->expiresIn;
    }

    public function setExpiresIn($expiresIn):void
    {
        // TODO: Implement setExpiresIn() method.
        $this->expiresIn = $expiresIn;
    }

    public function toJson(): string
    {
        return json_encode([
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn,
        ]);
    }
}