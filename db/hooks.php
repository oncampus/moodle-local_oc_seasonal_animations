<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Registers local_oc_seasonal_animations callbacks to Moodle core hooks.
 *
 * This file binds plugin logic to Moodle's hook system. In this case,
 * it connects the `before_footer_html_generation` hook to inject seasonal
 * effects on applicable pages.
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use core\hook\output\before_footer_html_generation;
use local_oc_seasonal_animations\hook\hook_callbacks;

$callbacks = [
    [
        'hook' => before_footer_html_generation::class,
        'callback' => hook_callbacks::class . '::before_footer_html_generation',
    ],
];
