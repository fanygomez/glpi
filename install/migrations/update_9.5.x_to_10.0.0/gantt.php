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
 * @var DB $DB
 * @var Migration $migration
 */

$default_charset = DBConnection::getDefaultCharset();
$default_collation = DBConnection::getDefaultCollation();

// Create table for project task links
if (!$DB->tableExists('glpi_projecttasklinks')) {
    $query = "CREATE TABLE `glpi_projecttasklinks` (
       `id` int NOT NULL AUTO_INCREMENT,
       `projecttasks_id_source` int NOT NULL,
       `source_uuid` varchar(255) NOT NULL,
       `projecttasks_id_target` int NOT NULL,
       `target_uuid` varchar(255) NOT NULL,
       `type` tinyint NOT NULL DEFAULT '0',
       `lag` smallint DEFAULT '0',
       `lead` smallint DEFAULT '0',
       PRIMARY KEY (`id`),
       KEY `projecttasks_id_source` (`projecttasks_id_source`),
       KEY `projecttasks_id_target` (`projecttasks_id_target`)
      ) ENGINE = InnoDB ROW_FORMAT = DYNAMIC DEFAULT CHARSET = {$default_charset} COLLATE = {$default_collation};";
    $DB->queryOrDie($query, "Adding table glpi_projecttasklinks");
}
