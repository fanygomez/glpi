<?php

/**
 * ---------------------------------------------------------------------
 * GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2015-2021 Teclib' and contributors.
 *
 * http://glpi-project.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * GLPI is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GLPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

namespace Glpi\Console\Cache;

use Glpi\Cache\CacheManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DebugCommand extends Command
{
    protected $requires_db_up_to_date = false;

    protected function configure()
    {
        parent::configure();

        $this->setName('glpi:cache:debug');
        $this->setAliases(['cache:debug']);
        $this->setDescription('Debug GLPI cache.');

        $this->addOption(
            'key',
            'k',
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            __('Cache key to debug.')
        );

        $this->addOption(
            'context',
            'c',
            InputOption::VALUE_REQUIRED,
            __('Cache context to clear (i.e. \'core\' or \'plugin:plugin_name\').'),
            CacheManager::CONTEXT_CORE
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $cache_manager = new CacheManager();

        $keys = $input->getOption('key');
        $context = $input->getOption('context');
        if (!in_array($context, $cache_manager->getKnownContexts())) {
            throw new \Symfony\Component\Console\Exception\InvalidArgumentException(
                sprintf(__('Invalid cache context: "%s".'), $context)
            );
        }

        $cache_instance = $cache_manager->getCacheInstance($context);

        foreach ($keys as $key) {
            if (!$cache_instance->has($key)) {
                $output->writeln('<comment>' . sprintf(__('Cache key "%s" is not set.'), $key) . '</comment>');
            } else {
                $output->writeln('<comment>' . sprintf(__('Cache key "%s" value:'), $key) . '</comment>');
                $output->writeln(json_encode($cache_instance->get($key), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            }
        }

        return 0; // Success
    }
}
