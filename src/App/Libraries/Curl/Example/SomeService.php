<?php

namespace TheBachtiarz\Base\App\Libraries\Curl\Example;

use TheBachtiarz\Base\App\Services\AbstractService;

class SomeService extends AbstractService
{
    //

    /**
     * Constructor
     *
     * @param CurlCustomerLibrary $curlCustomerLibrary
     */
    public function __construct(
        protected CurlCustomerLibrary $curlCustomerLibrary
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
            'email' => 'jane.doe@mail.test'
        ];

        $createProcess = $this->curlCustomerLibrary->execute('create-new-customer', $newCustomerData);

        $this->setResponseData($createProcess->getMessage(), $createProcess->getData());

        return $createProcess->toArray();
    }

    // ? Protected Methods

    // ? Private Methods

    // ? Getter Modules

    // ? Setter Modules
}
