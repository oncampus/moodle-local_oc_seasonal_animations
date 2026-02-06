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
