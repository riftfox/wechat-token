<?php

namespace Riftfox\Wechat\Token;

interface TokenFactoryInterface
{
    public function createTokenFormArray(array $data):TokenInterface;
}