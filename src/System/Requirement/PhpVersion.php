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

namespace Glpi\System\Requirement;

/**
 * @since 9.5.0
 */
class PhpVersion extends AbstractRequirement
{
   /**
    * Minimal required PHP version.
    *
    * @var string
    */
    private $min_version;

   /**
    * @param string $min_version  Minimal required PHP version
    */
    public function __construct(string $min_version)
    {
        $this->title = __('PHP Parser');
        $this->min_version = $min_version;
    }

    protected function check()
    {
        $this->validated = version_compare(PHP_VERSION, $this->min_version, '>=');

        $this->validation_messages[] = $this->validated
         ? sprintf(__('PHP version (%s) is supported.'), PHP_VERSION)
         : sprintf(__('PHP version must be at least %s.'), $this->min_version);
    }
}
