<?php

declare(strict_types=1);

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Libraries\Curl\Data\CurlResponseInterface;
use TheBachtiarz\Base\App\Services\AbstractService;

use function assert;

class SomeService extends AbstractService
{
    /**
     * Constructor
     */
    public function __construct(
        protected CurlCustomerLibrary $curlCustomerLibrary,
    ) {
        $this->curlCustomerLibrary = $curlCustomerLibrary;
    }

    // ? Public Methods

    /**
     * Create new dummy customer
     *
     * @return array
     */
    public function createNewCustomer(): array
    {
        $newCustomerData = [
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'gender' => 'female',
            'email' => 'jane.doe@mail.test',
        ];

        $createProcess = $this->curlCustomerLibrary->execute('create-new-customer', $newCustomerData);
        assert($createProcess instanceof CurlResponseInterface);

        $this->setResponseData(
            message: $createProcess->getMessage(),
            data: $createProcess->getData(),
            httpCode: 201,
        );

        return $createProcess->toArray();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
