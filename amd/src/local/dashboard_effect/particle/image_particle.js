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
 * Represents a particle rendered using a background image element.
 *
 * This custom element configures its size, opacity, and background image
 * based on plugin configurations, and is used as part of the effect system.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

import {getPluginConfigs} from "../../../dashboard_effect";
import {readRandomValue} from "../config/config_helper";

export class ImageParticle extends HTMLElement {


    /**
     * Lifecycle method triggered when the custom element is added to the DOM.
     *
     * Initializes the element's style properties using configuration values,
     * including background image, size, and opacity.
     */
    connectedCallback() {
        const configs = getPluginConfigs();
        const imageUrls = configs.particle_image_image || [""];

        if (typeof imageUrls !== 'object') {
            throw new Error("Invalid 'image' parameter: expected url.");
        }

        this.startSize = readRandomValue(configs.particle_image_size || "10;10") + 'px';
        this.startOpacity = readRandomValue(configs.particle_image_opacity || "0;1");

        const url = imageUrls[Math.floor(Math.random() * imageUrls.length)];
        this.style.position = 'absolute';
        this.style.pointerEvents = 'none';
        this.style.width = this.startSize;
        this.style.height = this.startSize;
        this.style.backgroundImage = `url(${url})`;
        this.style.backgroundSize = 'contain';
        this.style.backgroundRepeat = 'no-repeat';
        this.style.backgroundPosition = 'center';
        this.style.opacity = this.startOpacity;
    }
}
