<?php

namespace TheBachtiarz\Base;

class AppService
{
    //

    /**
     * Constructor
     */
    public function __construct()
    {
        // 
    }

    /**
     * Available command modules
     * 
     * @var array
     */
    public const COMMANDS = [];

    // ? Public Methods
    /**
     * Register config
     *
     * @return void
     */
    public function registerConfig(): void
    {
        $this->createDirectories();
        $this->setConfigs();
    }

    // ? Private Methods
    /**
     * Set configs
     *
     * @return void
     */
    private function setConfigs(): void
    {
        $container = \Illuminate\Container\Container::getInstance();

        /** @var DataService $_dataService */
        $_dataService = $container->make(DataService::class);

        foreach ($_dataService->registerConfig() as $key => $register)
            config($register);
    }

    /**
     * Create directories
     *
     * @return void
     */
    private function createDirectories(): void
    {
        if (!is_dir(tbdirlocation()))
            mkdir(tbdirlocation(), 0755);

        if (!is_dir(tbdirlocation("backup/log")))
            mkdir(tbdirlocation("backup/log"), 0755, true);

        if (!is_dir(tbdirlocation("backup/database")))
            mkdir(tbdirlocation("backup/database"), 0755, true);
    }

    // ? Setter Modules
}
