<?php

namespace Riftfox\Wechat\Token;

use Riftfox\Wechat\Application\ApplicationInterface;

interface TokenProviderInterface
{
    const TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/token';
    const STABLE_TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/stable_token';
    public function token(ApplicationInterface $application, bool $forceRefresh = false): TokenInterface;
}