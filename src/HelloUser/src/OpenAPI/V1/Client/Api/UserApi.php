<?php
/**
 * UserApi
 * PHP version 7.2
 *
 * @category Class
 * @package  HelloUser\OpenAPI\V1\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * HelloUser
 *
 * No description provided (generated by Openapi Generator https://github.com/openapitools/openapi-generator)
 *
 * The version of the OpenAPI document: 1
 *
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 4.3.1
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace HelloUser\OpenAPI\V1\Client\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;
use OpenAPI\Client\Api\ApiInterface;
use OpenAPI\Client\ApiException;
use HelloUser\OpenAPI\V1\Client\Configuration;
use OpenAPI\Client\HeaderSelector;
use OpenAPI\Client\ObjectSerializer;
use Psr\Log\LoggerInterface;

/**
 * UserApi Class Doc Comment
 *
 * @category Class
 * @package  HelloUser\OpenAPI\V1\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class UserApi implements ApiInterface
{
    public const CONFIGURATION_CLASS = 'HelloUser\OpenAPI\V1\Client\Configuration';

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /**
     * @var LoggerInterface|null
     */
    private $logger;

    /**
     * @param ClientInterface|null $client
     * @param Configuration|null $config
     * @param HeaderSelector|null $selector
     * @param int $hostIndex (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration   $config = null,
        HeaderSelector  $selector = null,
                        $hostIndex = 0,
        LoggerInterface $logger = null
    )
    {
        $this->client = $client ?: new Client();
        $this->config = $config ?: Configuration::getDefaultConfiguration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
        $this->logger = $logger;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function setHostIndex(int $hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int
     */
    public function getHostIndex(): int
    {
        return $this->hostIndex;
    }

    /**
     * {@inheritDoc}
     */
    public function getHosts(): array
    {
        return $this->config->getHostSettings();
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation userIdGet
     *
     * @param mixed $id id (required)
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws ApiException on non-2xx response
     */
    public function userIdGet($id)
    {
        list($response) = $this->userIdGetWithHttpInfo($id);
        return $response;
    }

    /**
     * Operation userIdGetWithHttpInfo
     *
     * @param mixed $id (required)
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws ApiException on non-2xx response
     */
    public function userIdGetWithHttpInfo($id)
    {
        $request = $this->userIdGetRequest($id);

        $this->log('info', 'Openapi send request.', [
            'requestBody' => (string)$request->getBody(),
            'requestUri' => (string)$request->getUri()
        ]);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);

                $this->log('info', 'Openapi response successfully received.', [
                    'class' => self::class,
                    'responseBody' => (string)$response->getBody(),
                    'responseStatusCode' => $response->getStatusCode()
                ]);
            } catch (RequestException $e) {
                if (!$e->hasResponse()) {
                    throw $e;
                }
                $response = $e->getResponse();

                $this->log('info', 'Openapi not 2xx response received.', [
                    'class' => self::class,
                    'responseBody' => (string)$response->getBody(),
                    'responseStatusCode' => $response->getStatusCode()
                ]);
            }

            $statusCode = $response->getStatusCode();

            $responseBody = $response->getBody();
            switch ($statusCode) {
                case 200:
                    return [
                        $this->deserialize((string)$responseBody),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 404:
                    return [
                        $this->deserialize((string)$responseBody),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    return [
                        $this->deserialize((string)$responseBody),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            return [
                $this->deserialize((string)$responseBody),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->deserialize((string)$e->getResponseBody());
                    $e->setResponseObject($data);
                    break;
                case 404:
                    $data = $this->deserialize((string)$e->getResponseBody());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->deserialize((string)$e->getResponseBody());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation userIdGetAsync
     *
     *
     *
     * @param mixed $id (required)
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @throws \InvalidArgumentException
     */
    public function userIdGetAsync($id)
    {
        return $this->userIdGetAsyncWithHttpInfo($id)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation userIdGetAsyncWithHttpInfo
     *
     *
     *
     * @param mixed $id (required)
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @throws \InvalidArgumentException
     */
    public function userIdGetAsyncWithHttpInfo($id)
    {
        $request = $this->userIdGetRequest($id);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) {
                    return [
                        $this->deserialize((string)$response->getBody()),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'userIdGet'
     *
     * @param mixed $id (required)
     *
     * @return \GuzzleHttp\Psr7\Request
     * @throws \InvalidArgumentException
     */
    protected function userIdGetRequest($id)
    {
        // verify the required parameter 'id' is set
        if ($id === null || (is_array($id) && count($id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $id when calling userIdGet'
            );
        }

        $resourcePath = '/User/{id}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // path params
        if ($id !== null) {
            $resourcePath = str_replace(
                '{' . 'id' . '}',
                ObjectSerializer::toPathValue($id),
                $resourcePath
            );
        }

        // body params
        $_tempBody = null;

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                []
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($_tempBody);
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = Query::build($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = Query::build($queryParams);
        return new Request(
            'GET',
            $this->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation userPost
     *
     * @param mixed $user user (required)
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws ApiException on non-2xx response
     */
    public function userPost($user)
    {
        list($response) = $this->userPostWithHttpInfo($user);
        return $response;
    }

    /**
     * Operation userPostWithHttpInfo
     *
     * @param mixed $user (required)
     *
     * @return array
     * @throws \InvalidArgumentException
     * @throws ApiException on non-2xx response
     */
    public function userPostWithHttpInfo($user)
    {
        $request = $this->userPostRequest($user);

        $this->log('info', 'Openapi send request.', [
            'requestBody' => (string)$request->getBody(),
            'requestUri' => (string)$request->getUri()
        ]);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);

                $this->log('info', 'Openapi response successfully received.', [
                    'class' => self::class,
                    'responseBody' => (string)$response->getBody(),
                    'responseStatusCode' => $response->getStatusCode()
                ]);
            } catch (RequestException $e) {
                if (!$e->hasResponse()) {
                    throw $e;
                }
                $response = $e->getResponse();

                $this->log('info', 'Openapi not 2xx response received.', [
                    'class' => self::class,
                    'responseBody' => (string)$response->getBody(),
                    'responseStatusCode' => $response->getStatusCode()
                ]);
            }

            $statusCode = $response->getStatusCode();

            $responseBody = $response->getBody();
            switch ($statusCode) {
                case 201:
                    return [
                        $this->deserialize((string)$responseBody),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 400:
                    return [
                        $this->deserialize((string)$responseBody),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 500:
                    return [
                        $this->deserialize((string)$responseBody),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            return [
                $this->deserialize((string)$responseBody),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->deserialize((string)$e->getResponseBody());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->deserialize((string)$e->getResponseBody());
                    $e->setResponseObject($data);
                    break;
                case 500:
                    $data = $this->deserialize((string)$e->getResponseBody());
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation userPostAsync
     *
     *
     *
     * @param mixed $user (required)
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @throws \InvalidArgumentException
     */
    public function userPostAsync($user)
    {
        return $this->userPostAsyncWithHttpInfo($user)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation userPostAsyncWithHttpInfo
     *
     *
     *
     * @param mixed $user (required)
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     * @throws \InvalidArgumentException
     */
    public function userPostAsyncWithHttpInfo($user)
    {
        $request = $this->userPostRequest($user);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) {
                    return [
                        $this->deserialize((string)$response->getBody()),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'userPost'
     *
     * @param mixed $user (required)
     *
     * @return \GuzzleHttp\Psr7\Request
     * @throws \InvalidArgumentException
     */
    protected function userPostRequest($user)
    {
        // verify the required parameter 'user' is set
        if ($user === null || (is_array($user) && count($user) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $user when calling userPost'
            );
        }

        $resourcePath = '/User';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;


        // body params
        $_tempBody = null;
        if (isset($user)) {
            $_tempBody = $user;
        }

        if ($multipart) {
            $headers = $this->headerSelector->selectHeadersForMultipart(
                ['application/json']
            );
        } else {
            $headers = $this->headerSelector->selectHeaders(
                ['application/json'],
                ['application/json']
            );
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            // $_tempBody is the method argument, if present
            if ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($_tempBody);
            } else {
                $httpBody = $_tempBody;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $multipartContents[] = [
                        'name' => $formParamName,
                        'contents' => $formParamValue
                    ];
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif ($headers['Content-Type'] === 'application/json') {
                $httpBody = \GuzzleHttp\json_encode($formParams);

            } else {
                // for HTTP post (form)
                $httpBody = Query::build($formParams);
            }
        }


        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $query = Query::build($queryParams);
        return new Request(
            'POST',
            $this->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @return array of http client options
     * @throws \RuntimeException on file opening failure
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }

    /**
     * Returns host by hostIndex
     *
     * @return string
     */
    protected function getHost(): string
    {
        return $this->config->getHostFromSettings($this->hostIndex);
    }

    /**
     * Decodes response body
     *
     * @param string $responseBody
     * @return array
     */
    protected function deserialize(string $responseBody): array
    {
        try {
            return ObjectSerializer::deserialize($responseBody);
        } catch (InvalidArgumentException $exception) {
            return [
                'data' => null,
                'messages' => [
                    [
                        'level' => 'error',
                        'type' => 'INVALID_RESPONSE',
                        'text' => 'Response body decoding error: "' . $exception->getMessage() . '"'
                    ]
                ]
            ];
        }
    }

    /*protected function deserialize(string $responseBody, ?string $mimeType = null)
    {
        $mimeType = $mimeType ?? 'application/json';
        switch ($mimeType) {
            case 'application/json':
            case 'application/vnd.api+json':
            try {
                return ObjectSerializer::deserialize($responseBody);
            } catch (InvalidArgumentException $exception) {
                return [
                    'data' => null,
                    'messages' => [
                        [
                            'level' => 'error',
                            'type' => 'INVALID_RESPONSE',
                            'text' => 'Response body decoding error: "' . $exception->getMessage() . '"'
                        ]
                    ]
                ];
            }
        }

        return $responseBody;
    }*/

    protected function log(string $level, string $message, array $context): void
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }
}
