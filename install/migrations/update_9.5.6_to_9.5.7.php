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

/**
 * Update from 9.5.6 to 9.5.7
 *
 * @return bool for success (will die for most error)
 **/
function update956to957()
{
   /** @global Migration $migration */
    global $DB, $migration, $CFG_GLPI;

    $current_config   = Config::getConfigurationValues('core');
    $updateresult     = true;
    $ADDTODISPLAYPREF = [];

   //TRANS: %s is the number of new version
    $migration->displayTitle(sprintf(__('Update to %s'), '9.5.7'));
    $migration->setVersion('9.5.7');

   /* Fix null `date` in ITIL tables */
    $itil_tables = ['glpi_changes', 'glpi_problems', 'glpi_tickets'];
    foreach ($itil_tables as $itil_table) {
        $migration->addPostQuery(
            $DB->buildUpdate(
                $itil_table,
                ['date' => new QueryExpression($DB->quoteName($itil_table . '.date_creation'))],
                ['date' => null]
            )
        );
    }
   /* /Fix null `date` in ITIL tables */

   // ************ Keep it at the end **************
    $migration->executeMigration();

    return $updateresult;
}
