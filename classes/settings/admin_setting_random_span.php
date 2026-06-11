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

namespace local_oc_seasonal_animations\settings;

use admin_setting;
use ValueError;

/**
 * Provides a custom admin setting for defining a span between two float values.
 *
 * This setting stores two values (minimum and maximum) and internally calculates
 * and stores the difference as "min;delta" format. It is used in the Moodle admin
 * interface to allow configuration with random variation.
 *
 * @package    local_oc_seasonal_animations
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admin_setting_random_span extends admin_setting {
    /**
     * Retrieves the current setting value from configuration storage.
     *
     * @return mixed The stored value.
     */
    public function get_setting(): mixed {
        return $this->config_read($this->name);
    }

    /**
     * Validates and writes the setting value into configuration storage.
     *
     * Converts the min and max values into a "min;delta" format before storing.
     *
     * @param mixed $data The input data, expected as an associative array with 'min' and 'max'.
     * @return string Empty string on success, or an error message.
     */
    public function write_setting(mixed $data): string {
        if ($data === null) {
            return (set_config($this->name, null, $this->plugin) ? '' : get_string('errorsetting', 'admin'));
        }

        $validated = $this->validate($data);
        if ($validated !== true) {
            return $validated;
        }

        $min = isset($data['min']) ? (float) trim($data['min']) : 0;
        $max = isset($data['max']) ? (float) trim($data['max']) : 0;
        $data = $min . ';' . ($max - $min);

        return (set_config($this->name, $data, $this->plugin) ? '' : get_string('errorsetting', 'admin'));
    }

    /**
     * Validates the input data to ensure it is a valid range.
     *
     * Ensures both 'min' and 'max' values are numeric and that min is not greater than max.
     *
     * @param mixed $data The data to validate.
     * @return true|string True if valid, otherwise an error message.
     */
    protected function validate(mixed $data) {
        if (!is_array($data)) {
            return get_string('validateerror', 'admin');
        }

        if (!isset($data['min'], $data['max'])) {
            return get_string('validateerror', 'admin');
        }

        $min = trim($data['min']);
        $max = trim($data['max']);

        if (!is_numeric($min) || !is_numeric($max)) {
            return get_string('validateerror', 'admin');
        }

        if ((float)$min > (float)$max) {
            return get_string('validateerror', 'admin');
        }

        return true;
    }

    /**
     * Generates the HTML for this setting, rendering a template with input fields.
     *
     * Formats and populates the min and max values for rendering in the settings UI.
     *
     * @param mixed $data The current value of the setting.
     * @param string $query Optional search query to highlight in the UI.
     * @return string The rendered HTML for the setting.
     */
    public function output_html($data, $query = ''): string {
        global $OUTPUT;

        $default = $this->get_defaultsetting();
        $fdefault = $default['min'] . ' - ' . $default['max'];

        if ($data === false) {
            $data = $default;
        } else if (is_string($data)) {
            $split = explode(';', $data);
            $constant = (float) ($split[0] ?? '0');
            $random = (float) ($split[1] ?? '0');
            $data = [
                'min' => $constant,
                'max' => $constant + $random,
            ];
        } else if (!is_array($data)) {
            throw new ValueError("Value cannot be parsed");
        }

        $context = (object) [
            'size' => 5,
            'id' => $this->get_id(),
            'name' => $this->get_full_name(),
            'min' => $data['min'],
            'max' => $data['max'],
            'readonly' => $this->is_readonly(),
        ];
        $element = $OUTPUT->render_from_template('local_oc_seasonal_animations/setting_random_span', $context);

        return format_admin_setting($this, $this->visiblename, $element, $this->description, false, '', $fdefault, $query);
    }
}
