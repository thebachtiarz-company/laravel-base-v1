<?php

namespace TheBachtiarz\Base\App\Libraries\Curl;

use Illuminate\Container\Container;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http as CURL;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponse;
use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\Base\App\Libraries\Curl\Log\LogLibrary;

abstract class AbstractCurl implements CurlInterface
{
    //

    /**
     * Url path
     *
     * @var string
     */
    protected string $path = '';

    /**
     * Url request
     *
     * @var string
     */
    protected string $url = '';

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
     *
     * @var string|null
     */
    protected ?string $token = null;

    /**
     * User agent
     *
     * @var string|null
     */
    protected ?string $userAgent = null;

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
     *
     * @return CurlResponseInterface
     */
    public function get(): CurlResponseInterface
    {
        return $this->sendRequest('get');
    }

    /**
     * Send request with method: POST
     *
     * @return CurlResponseInterface
     */
    public function post(): CurlResponseInterface
    {
        return $this->sendRequest('post');
    }

    // ? Protected Methods
    /**
     * Url domain resolver
     *
     * @return string
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
     *
     * @param string $method
     * @return CurlResponseInterface
     */
    protected function sendRequest(string $method): CurlResponseInterface
    {
        $pendingRequest = $this->curl();

        if ($this->token)
            $pendingRequest->withToken($this->token);

        if ($this->userAgent)
            $pendingRequest->withUserAgent($this->userAgent);

        /** @var Response $response */
        $response = $pendingRequest->{$method}($this->urlDomainResolver(), $this->bodyDataResolver());

        return $this->response($response);
    }

    /**
     * Get log instance
     *
     * @return LogLibrary
     */
    protected function logInstance(): LogLibrary
    {
        return Container::getInstance()->make(LogLibrary::class);
    }

    // ? Private Methods
    /**
     * Request curl init
     *
     * @return PendingRequest
     */
    private function curl(): PendingRequest
    {
        $_headers = [
            'Accept' => 'application/json'
        ];

        if (count($this->header))
            $_headers = array_merge($_headers, $this->header);

        return CURL::withHeaders($_headers);
    }

    /**
     * Request curl response
     *
     * @param Response $response
     * @return CurlResponseInterface
     */
    private function response(Response $response): CurlResponseInterface
    {
        /** @var CurlResponseInterface $result */
        $result = new CurlResponse;

        try {
            $_response = $response->json();

            /**
             * If there is validation errors
             */
            throw_if(in_array("errors", array_keys($_response)), 'Exception', $_response['message']);

            /**
             * If there is no 'status' indexes. Assume there is an error in the result.
             */
            throw_if(!@$_response['status'], 'Exception', $_response['message']);

            /**
             * If return status is not success
             */
            throw_if($_response['status'] !== "success", 'Exception', $_response['message']);

            $result->setStatus($_response['status'] === "success");
            $result->setMessage($_response['message']);
            $result->setData($_response['data']);
        } catch (\Throwable $th) {
            $this->logInstance()->log($th);

            $result->setMessage($th->getMessage());
        } finally {
            $this->logInstance()->override()->log($result);

            return $result;
        }
    }

    // ? Getter Modules
    /**
     * Get url path
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Get url request
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
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
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Get user agent
     *
     * @return string|null
     */
    public function getUserAgent(): ?string
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
     *
     * @param string $path
     * @return self
     */
    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Set url request
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Set header request
     *
     * @param array $header
     * @return self
     */
    public function setHeader(array $header): self
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Set bearer token
     *
     * @param string|null $token
     * @return self
     */
    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Set user agent
     *
     * @param string|null $userAgent
     * @return self
     */
    public function setUserAgent(?string $userAgent): self
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Set body request
     *
     * @param array $body
     * @return self
     */
    public function setBody(array $body): self
    {
        $this->body = $body;

        return $this;
    }
}
