// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Represents a snowflake particle styled as a circular div element.
 *
 * This custom element sets its color, size, and opacity based on plugin
 * configuration values, and forms part of the animated snow effect.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

import {getPluginConfigs} from "../../../dashboard_effect";
import {readRandomValue} from "../config/config_helper";

export class SnowParticle extends HTMLElement {
    /**
     * Lifecycle method triggered when the custom element is added to the DOM.
     *
     * Initializes the element with absolute positioning, a circular shape,
     * and visual properties defined by the plugin configuration.
     */
    connectedCallback() {
        const configs = getPluginConfigs();
        const color = configs.particle_snow_color || '#ffffff';
        this.startSize = readRandomValue(configs.particle_snow_size || "2;3") + 'px';
        window.console.log(this.startSize);
        this.startOpacity = readRandomValue(configs.particle_snow_opacity || "0;1");

        this.style.position = 'absolute';
        this.style.backgroundColor = color;
        this.style.borderRadius = '50%';
        this.style.width = this.startSize;
        this.style.height = this.startSize;
        this.style.opacity = this.startOpacity;
    }
}
