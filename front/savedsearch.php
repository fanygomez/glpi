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

if (!defined('GLPI_ROOT')) {
    include('../inc/includes.php');
}

if (Session::getCurrentInterface() == "helpdesk") {
    Html::helpHeader(SavedSearch::getTypeName(Session::getPluralNumber()));
} else {
    Html::header(SavedSearch::getTypeName(Session::getPluralNumber()), $_SERVER['PHP_SELF'], 'tools', 'savedsearch');
}

$savedsearch = new SavedSearch();

if (
    isset($_GET['action']) && $_GET["action"] == "load"
    && isset($_GET["id"]) && ($_GET["id"] > 0)
) {
    $savedsearch->check($_GET["id"], READ);
    $savedsearch->load($_GET["id"]);
    return;
}

Search::show('SavedSearch');
Html::footer();
