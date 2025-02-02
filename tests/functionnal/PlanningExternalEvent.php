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

namespace tests\units;

include_once __DIR__ . '/../abstracts/AbstractPlanningEvent.php';

class PlanningExternalEvent extends \AbstractPlanningEvent
{
    public $myclass = "\PlanningExternalEvent";


    public function testAddInstanceException()
    {
        $this->login();

        $event     = new $this->myclass();
        $id        = $event->add($this->input);
        $exception = date('Y-m-d', $this->now + DAY_TIMESTAMP);

        $this->boolean($event->addInstanceException($id, $exception))->isTrue();

        $rrule = json_decode($event->fields['rrule'], true);
        $this->array($rrule['exceptions'])
         ->hasSize(3) // original event has 2 exceptions, we add one
         ->contains($exception);
    }


    public function testCreateInstanceClone()
    {
        $this->login();

        $event     = new $this->myclass();
        $serie_id  = $event->add($this->input);
        $start     = date('Y-m-d H:i:s', $this->now + DAY_TIMESTAMP);
        $start_day = date('Y-m-d', $this->now + DAY_TIMESTAMP);

       // the clone of serie should not have rrule
        $new_event = $event->createInstanceClone($serie_id, $start);
        $this->object($new_event)->isInstanceOf($this->myclass);
        $this->integer($new_event->fields['id'])->isNotEqualTo($serie_id);
        $this->variable($new_event->fields['rrule'])->isNull();

       // original event should have the instance exception
        $rrule = json_decode($event->fields['rrule'], true);
        $this->array($rrule['exceptions'])
         ->hasSize(3) // original event has 2 exceptions, we add one
         ->contains($start_day);
    }
}
