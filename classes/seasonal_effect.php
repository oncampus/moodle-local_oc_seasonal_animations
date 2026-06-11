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

namespace local_oc_seasonal_animations;

use coding_exception;
use context_system;
use core\output\html_writer;
use moodle_url;

/**
 * Integrates seasonal particle effects into Moodle pages.
 *
 * This class dynamically injects a particle effect based on seasonal
 * configurations. It can be applied forcefully or based on user-defined rules
 * and includes logic to serve seasonal image assets.
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class seasonal_effect {
    /**
     * Adds a toggle button and the custom <snow-effect> element to the DOM
     *
     * @return string HTML code needed for the saisonal effects
     * @throws coding_exception
     */
    public static function get_seasonal_effect_html(): string {
        $togglebutton = html_writer::tag(
            'button',
            get_string('disable_snowfall', 'local_oc_seasonal_animations'),
            ['id' => 'snowfall-toggle-btn', 'class' => 'btn btn-secondary']
        );

        // Include the toggle button and snow-effect element in the page.
        $html = html_writer::div($togglebutton, 'snowfall-toggle-container');
        $html .= html_writer::tag('snow-effect', '', ['id' => 'snow-component']);
        return $html;
    }

    /**
     * Injects JavaScript into the Moodle page.
     *
     * loads the corresponding AMD module with season-based configurations.
     *
     * @param season $season Season to render
     * @return void
     */
    public static function render(season $season): void {
        global $PAGE;

        $PAGE->requires->js_call_amd(
            'local_oc_seasonal_animations/dashboard_effect',
            'init',
            ['configs' => $season->get_animation_configs()],
        );
    }
}
