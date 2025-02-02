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

/// Class DeviceBatteryModel
abstract class CommonDeviceModel extends CommonDropdown
{
    public static function getTypeName($nb = 0)
    {
        return _n('Device model', 'Device models', $nb);
    }

    public static function getFormURL($full = true)
    {
        global $CFG_GLPI;

        $dir = ($full ? $CFG_GLPI['root_doc'] : '');
        $itemtype = get_called_class();
        $link = "$dir/front/devicemodel.form.php?itemtype=$itemtype";

        return $link;
    }

    public static function getSearchURL($full = true)
    {
        global $CFG_GLPI;

        $dir = ($full ? $CFG_GLPI['root_doc'] : '');
        $itemtype = get_called_class();
        $link = "$dir/front/devicemodel.php?itemtype=$itemtype";

        return $link;
    }

    public static function getIcon()
    {
        $model_class  = get_called_class();
        $device_class = str_replace('Model', '', $model_class);
        return $device_class::getIcon();
    }
}
