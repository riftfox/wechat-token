<?php

namespace Riftfox\Wechat\Token;

use Riftfox\Wechat\AccessToken\AccessToken;
use Riftfox\Wechat\Token\TokenFactoryInterface;

class TokenFactory implements TokenFactoryInterface
{

    public function createTokenFormArray(array $data): TokenInterface
    {
        // TODO: Implement createTokenFormArray() method.
        if (!isset($data['access_token']) || !isset($data['expires_in'])) {
            throw new \InvalidArgumentException('Invalid response from WeChat API: missing access_token or expires_in');
        }
        return new AccessToken($data['access_token'], $data['expires_in']);
    }
}