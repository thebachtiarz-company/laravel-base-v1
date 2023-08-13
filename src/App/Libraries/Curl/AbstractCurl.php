<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as CURL;
use TheBachtiarz\Base\App\Interfaces\Helpers\ResponseInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponse;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Log\LogLibrary;
use Throwable;

use function app;
use function array_keys;
use function array_merge;
use function assert;
use function count;
use function in_array;
use function throw_if;

abstract class AbstractCurl implements CurlInterface
{
    /**
     * Url path
     */
    protected string $path = '';

    /**
     * Url request
     */
    protected string $url = '';

    /**
     * Sub url request
     */
    protected string $subUrl = '';

    /**
     * Header request
     *
     * @var array
     */
    protected array $header = [];

    /**
     * Token authorization
     *
     * Type: Bearer
     */
    protected string|null $token = null;

    /**
     * User agent
     */
    protected string|null $userAgent = null;

    /**
     * Body request
     *
     * @var array
     */
    protected array $body = [];

    // ? Public Methods

    /**
     * {@inheritDoc}
     */
    abstract public function execute(array $data = []): CurlResponseInterface;

    /**
     * Send request with method: GET
     */
    public function get(): CurlResponseInterface
    {
        return $this->sendRequest('get');
    }

    /**
     * Send request with method: POST
     */
    public function post(): CurlResponseInterface
    {
        return $this->sendRequest('post');
    }

    // ? Protected Methods

    /**
     * Url domain resolver
     */
    abstract protected function urlDomainResolver(): string;

    /**
     * Body data resolver
     *
     * @return array
     */
    abstract protected function bodyDataResolver(): array;

    /**
     * Request curl send
     */
    protected function sendRequest(string $method): CurlResponseInterface
    {
        $pendingRequest = $this->curl();

        if ($this->token) {
            $pendingRequest->withToken($this->token);
        }

        if ($this->userAgent) {
            $pendingRequest->withUserAgent($this->userAgent);
        }

        $response = $pendingRequest->{$method}($this->urlDomainResolver(), $this->bodyDataResolver());
        assert($response instanceof Response);

        return $this->response($response);
    }

    /**
     * Get log instance
     */
    protected function logInstance(): LogLibrary
    {
        return app(LogLibrary::class);
    }

    // ? Private Methods

    /**
     * Request curl init
     */
    private function curl(): PendingRequest
    {
        $headers = ['Accept' => 'application/json'];

        if (count($this->header)) {
            $headers = array_merge($headers, $this->header);
        }

        return CURL::withHeaders($headers);
    }

    /**
     * Request curl response
     */
    private function response(Response $response): CurlResponseInterface
    {
        $result = new CurlResponse();
        assert($result instanceof CurlResponseInterface);

        try {
            $response = $response->json();

            /**
             * If there is validation errors
             */
            throw_if(in_array('errors', array_keys($response)), 'Exception', $response[ResponseInterface::ATTRIBUTE_MESSAGE]);

            /**
             * If there is no 'status' indexes. Assume there is an error in the result.
             */
            throw_if(
                ! @$response[ResponseInterface::ATTRIBUTE_STATUS],
                'Exception',
                $response[ResponseInterface::ATTRIBUTE_MESSAGE],
            );

            /**
             * If return status is not success
             */
            throw_if(
                $response[ResponseInterface::ATTRIBUTE_STATUS] !== 'success',
                'Exception',
                $response[ResponseInterface::ATTRIBUTE_MESSAGE],
            );

            $result = new CurlResponse($response);
        } catch (Throwable $th) {
            $this->logInstance()->log($th);

            $result->setMessage($th->getMessage());
        } finally {
            $this->logInstance()->override()->log($result->toArray());

            return $result;
        }
    }

    // ? Getter Modules

    /**
     * Get url path
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get url request
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get sub url
     */
    public function getSubUrl(): string
    {
        return $this->subUrl;
    }

    /**
     * Get header request
     *
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * Get bearer token
     */
    public function getToken(): string|null
    {
        return $this->token;
    }

    /**
     * Get user agent
     */
    public function getUserAgent(): string|null
    {
        return $this->userAgent;
    }

    /**
     * Get body request
     *
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    // ? Setter Modules

    /**
     * Set url path
     */
    public function setPath(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set url request
     */
    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set sub url
     *
     * @return self
     */
    public function setSubUrl(string $subUrl): static
    {
        $this->subUrl = $subUrl;

        return $this;
    }

    /**
     * Set header request
     *
     * @param array $header
     */
    public function setHeader(array $header): static
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Set bearer token
     */
    public function setToken(string|null $token): static
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set user agent
     */
    public function setUserAgent(string|null $userAgent): static
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Set body request
     *
     * @param array $body
     */
    public function setBody(array $body): static
    {
        $this->body = $body;

        return $this;
    }
}
