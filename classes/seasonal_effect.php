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
     * Prefix constants for configuration keys per season
     */
    public const SEASONLESS = 'seasonless_';
    /**
     * Prefix constants for configuration keys per season
     */
    public const SPRING = 'spring_';
    /**
     * Prefix constants for configuration keys per season
     */
    public const SUMMER = 'summer_';
    /**
     * Prefix constants for configuration keys per season
     */
    public const AUTUMN = 'autumn_';
    /**
     * Prefix constants for configuration keys per season
     */
    public const WINTER = 'winter_';

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
     * @param array $configs Configs for the wanted season.
     * @return void
     */
    public static function render(array $configs): void {
        global $PAGE;

        $PAGE->requires->js_call_amd(
            'local_oc_seasonal_animations/dashboard_effect',
            'init',
            ['configs' => $configs],
        );
    }

    /**
     * Loads all configuration values for a specified season prefix.
     *
     * Extracts relevant configuration keys and includes particle image URL if available.
     *
     * @param string $yeartime The seasonal configuration prefix.
     * @return array Associative array of configuration values.
     */
    public static function get_yeartime_configs(string $yeartime): array {
        $allconfigs = (array) get_config('local_oc_seasonal_animations');
        $configs = [];

        foreach ($allconfigs as $key => $value) {
            if (str_starts_with($key, $yeartime)) {
                $cut = substr($key, strlen($yeartime));
                $configs[$cut] = $value;
            }
        }

        $configs['particle_image_image'] = self::get_image_particle_files($yeartime);
        return $configs;
    }

    /**
     * Retrieves a URL for the particle image based on season.
     *
     * If a file exists in the configured file area, its plugin file URL is returned.
     * Otherwise, a default seasonal image path is returned where applicable.
     *
     * @param string $yeartime The seasonal configuration prefix.
     * @return string|null The image URL or null if not applicable.
     */
    private static function get_image_particle_files(string $yeartime): array|null {
        global $OUTPUT;

        $context = context_system::instance();
        $component = 'local_oc_seasonal_animations';
        $filearea = "{$yeartime}particle_image_image_file";
        $itemid = 0;
        $fs = get_file_storage();

        $files = $fs->get_area_files($context->id, $component, $filearea, $itemid, "itemid, filepath, filename", false);

        if ($files) {
            $urls = [];

            foreach ($files as $file) {
                $url = moodle_url::make_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    $file->get_itemid(),
                    $file->get_filepath(),
                    $file->get_filename()
                );
                $urls[] = $url->out();
            }

            return $urls;
        }

        return match ($yeartime) {
            self::SEASONLESS, self::WINTER => null,
            self::SPRING => [
                $OUTPUT->image_url('cherry_blossom', 'local_oc_seasonal_animations')->out(),
                $OUTPUT->image_url('almond_blossom', 'local_oc_seasonal_animations')->out(),
            ],
            self::SUMMER => [
                $OUTPUT->image_url('bubble', 'local_oc_seasonal_animations')->out(),
            ],
            self::AUTUMN => [
                $OUTPUT->image_url('oak_leave', 'local_oc_seasonal_animations')->out(),
                $OUTPUT->image_url('oak_leave', 'local_oc_seasonal_animations')->out(),
                $OUTPUT->image_url('maple_leave', 'local_oc_seasonal_animations')->out(),
                $OUTPUT->image_url('maple_leave', 'local_oc_seasonal_animations')->out(),
                $OUTPUT->image_url('pumkin', 'local_oc_seasonal_animations')->out(),
            ],
        };
    }

    /**
     * Determines the current seasonal configuration based on system date.
     *
     * Uses the 'season_change_enabled' setting to decide whether to dynamically
     * select seasonal configurations or fall back to the default.
     *
     * @return array Configuration values for the current season.
     */
    public static function get_current_configs(): array {
        $seasonalchange = get_config('local_oc_seasonal_animations', 'season_change_enabled');

        if (!$seasonalchange) {
            return self::get_yeartime_configs(self::SEASONLESS);
        }

        $month = date('n');

        if ($month >= 3 && $month <= 5) {
            return self::get_yeartime_configs(self::SPRING);
        } else if ($month >= 6 && $month <= 8) {
            return self::get_yeartime_configs(self::SUMMER);
        } else if ($month >= 9 && $month <= 11) {
            return self::get_yeartime_configs(self::AUTUMN);
        } else {
            return self::get_yeartime_configs(self::WINTER);
        }
    }
}
