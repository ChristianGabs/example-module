<?php

/**
 * FOSSBilling.
 *
 * @copyright FOSSBilling (https://www.fossbilling.org)
 * @license   Apache-2.0
 *
 * Copyright FOSSBilling 2022
 * This software may contain code previously used in the BoxBilling project.
 * Copyright BoxBilling, Inc 2011-2021
 *
 * This source file is subject to the Apache-2.0 License that is bundled
 * with this source code in the file LICENSE
 */

namespace Box\Mod\Example\Console;

use Pimple\Container;
use CristianG\PimpleConsole\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ExampleDI extends Command implements \FOSSBilling\InjectionAwareInterface
{
    protected ?Container $di = null;

    /**
     * @param  Container  $di
     * @return void
     */
    public function setDi(Container $di): void
    {
        $this->di = $di;
    }

    /**
     * @return Container|null
     */
    public function getDi(): ?Container
    {
        return $this->di;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('example:clear');
        $this->setDescription('Clear your cache in example');
        parent::configure();
    }

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $service = $this->di['mod_service']('system');
        try {
            $service->clearCache();
        } catch (\Exception $e) {
            $this->error("An error occurred: ".$e->getMessage());
            return Command::FAILURE;
        } finally {
            $this->info("Successfully cleared the cache.");
            return Command::SUCCESS;
        }
    }
}
