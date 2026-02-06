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

namespace local_oc_seasonal_animations\hook;

use local_oc_seasonal_animations\seasonal_effect;

/**
 * Hook callback class to apply seasonal effects on specific Moodle pages.
 *
 * This class registers a callback for injecting the seasonal effect only
 * on the frontpage and dashboard, leveraging Moodle's hook system.
 *
 * @package    local_oc_seasonal_animations
 * @subpackage hook
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class hook_callbacks {
    /**
     * Hook triggered before Moodle finishes rendering the page footer.
     *
     * Adds the seasonal effect to the frontpage and dashboard only,
     * by checking the current page type before injecting the effect.
     *
     * @return void
     */
    public static function before_footer_html_generation(): void {
        global $PAGE;

        // Check if current page is frontpage or dashboard.
        $allowedpages = [
            'site-index', // Frontpage.
            'my-index', // Dashboard.
        ];

        if (!in_array($PAGE->pagetype, $allowedpages)) {
            return;
        }

        seasonal_effect::apply_to_page();
    }
}
