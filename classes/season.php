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
use moodle_url;

/**
 * Animation setting configuration for season
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
enum season: string {
    case SEASONLESS = 'seasonless';
    case SPRING = 'spring';
    case SUMMER = 'summer';
    case AUTUMN = 'autumn';
    case WINTER = 'winter';

    /**
     * Determines the current season based on system date.
     *
     * Uses the 'season_change_enabled' setting to decide whether to dynamically
     * select seasonal configurations or fall back to the default.
     *
     * @return season Current season.
     */
    public static function get_current_season(): season {
        $seasonalchange = get_config('local_oc_seasonal_animations', 'season_change_enabled');

        if (!$seasonalchange) {
            return self::SEASONLESS;
        }

        $month = date('n');

        if ($month >= 3 && $month <= 5) {
            return self::SPRING;
        } else if ($month >= 6 && $month <= 8) {
            return self::SUMMER;
        } else if ($month >= 9 && $month <= 11) {
            return self::AUTUMN;
        } else {
            return self::WINTER;
        }
    }

    /**
     * Checks whether the current season animation is enabled
     *
     * @return bool True if animation is enabled
     * @throws \dml_exception
     */
    public function is_animaton_enabled(): bool {
        return (bool) get_config('local_oc_seasonal_animations', "{$this->value}_enabled");
    }

    /**
     * Get display name of season
     *
     * @return string Season display name
     * @throws coding_exception
     */
    public function get_label(): string {
        return get_string(
            "settings:$this->value",
            'local_oc_seasonal_animations'
        );
    }

    /**
     * Loads all configuration values for a specified season prefix.
     *
     * Extracts relevant configuration keys and includes particle image URL if available.
     *
     * @return array Associative array of configuration values.
     */
    public function get_animation_configs(): array {
        $allconfigs = (array) get_config('local_oc_seasonal_animations');
        $configs = [];
        $settingpre = "{$this->value}_";
        $settingpresize = strlen($settingpre);

        foreach ($allconfigs as $key => $value) {
            if (str_starts_with($key, $settingpre)) {
                $cut = substr($key, $settingpresize);
                $configs[$cut] = $value;
            }
        }

        $configs['particle_image_image'] = $this->get_image_particle_files();
        return $configs;
    }

    /**
     * Retrieves a URL for the particle image based on season.
     *
     * If a file exists in the configured file area, its plugin file URL is returned.
     * Otherwise, a default seasonal image path is returned where applicable.
     *
     * @return string|null The image URL or null if not applicable.
     */
    private function get_image_particle_files(): array|null {
        $context = context_system::instance();
        $component = 'local_oc_seasonal_animations';
        $filearea = $this->value . "_particle_image_image_file";
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

        return $this->get_standard_particale_image_urls();
    }

    /**
     * Returns URLs of the preconfigured images of a season
     *
     * @return array|null
     */
    private function get_standard_particale_image_urls(): array|null {
        global $OUTPUT;

        $imagenames = match ($this) {
            self::SEASONLESS, self::WINTER => [],
            self::SPRING => [
                'cherry_blossom',
                'almond_blossom',
            ],
            self::SUMMER => [
                'bubble',
            ],
            self::AUTUMN => [
                'oak_leave',
                'oak_leave',
                'maple_leave',
                'maple_leave',
                'pumkin',
            ],
        };

        if (empty($imagenames)) {
            return null;
        }

        return array_map(
            fn ($imagename) => $OUTPUT->image_url(
                $imagename,
                'local_oc_seasonal_animations'
            )->out(),
            $imagenames
        );
    }
}
