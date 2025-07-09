# wechat-token

本组件用于获取和管理微信调用接口凭据，提供统一的接口抽象，支持 access_token 与 stable_token 等不同类型凭据的获取与扩展。

## 设计思想

- 提供统一的 Token 获取接口，便于上层业务调用
- 针对 access_token 和 stable_token 的不同，设计抽象层，便于扩展和适配
- 支持自定义实现，满足不同业务场景

## 主要接口

### TokenInterface

```php
interface TokenInterface
{
    public function getAccessToken(): string;
    public function setAccessToken($accessToken);
    public function getExpiresIn(): int;
    public function setExpiresIn($expiresIn);
}
```

### TokenProviderInterface

```php
interface TokenProviderInterface
{
    const TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/token';
    const STABLE_TOKEN_URL = 'https://api.weixin.qq.com/cgi-bin/stable_token';
    public function token(ApplicationInterface $application, bool $forceRefresh = false): TokenInterface;
}
```

### TokenFactoryInterface

```php
interface TokenFactoryInterface
{
    public function createTokenFormArray(array $data): TokenInterface;
}
```

### TokenProvider（抽象类）

`TokenProvider` 实现了 TokenProviderInterface 的大部分逻辑，负责：
- 发送请求获取 token
- 处理异常和日志
- 通过工厂创建 Token 实例
- 需实现 `getRequest` 方法自定义请求

```php
abstract class TokenProvider implements TokenProviderInterface
{
    // ... 构造与依赖注入 ...
    public function token(ApplicationInterface $application, bool $forceRefresh = false): TokenInterface;
    public function setLogger(LoggerInterface $logger): void;
    public abstract function getRequest(ApplicationInterface $application, bool $forceRefresh = false): RequestInterface;
}
```

## 使用示例

```php
use Riftfox\Wechat\Token\TokenProviderInterface;
use Riftfox\Wechat\Token\TokenInterface;

class MyTokenProvider extends TokenProvider
{
    public function getRequest(ApplicationInterface $application, bool $forceRefresh = false): RequestInterface
    {
        // 构建并返回 PSR-7 RequestInterface 实例
    }
}

$provider = new MyTokenProvider($client, $tokenFactory, $exceptionFactory);
$token = $provider->token($application);
$accessToken = $token->getAccessToken();
```

## 扩展方式

- 实现 `TokenProviderInterface` 或继承 `TokenProvider`，可自定义 token 获取逻辑
- 实现 `TokenFactoryInterface`，可自定义 token 数据结构
- 可结合缓存、自动刷新等机制

## 依赖

- psr/http-client
- psr/http-factory
- psr/simple-cache
- psr/log
- riftfox/wechat-exception
- riftfox/wechat-application

## 贡献与反馈

如有建议或问题，欢迎提交 issue 或联系作者。

---

作者：Riftfox  
邮箱：riftfox@riftfox.com