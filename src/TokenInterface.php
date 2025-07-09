<?php

namespace Riftfox\Wechat\Token;

interface TokenInterface
{
    public function getAccessToken():string;
    public function setAccessToken($accessToken);
    public function getExpiresIn():int;
    public function setExpiresIn($expiresIn);
}