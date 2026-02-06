/**
 * Implements a fade-in and fade-out animation behavior for particles.
 *
 * Particles cycle between appearing and disappearing by adjusting opacity,
 * and are reset to their start position once fully transparent.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

import {getPluginConfigs} from "../../../dashboard_effect";
import {readRandomValue} from "../config/config_helper";


export class FadeBehavior {
    /**
     * Constructs the fade behavior with a reference to a start position strategy.
     *
     * @param {Object} startPosition - Strategy used to reset particle position.
     */
    constructor(startPosition) {
        this.startPosition = startPosition;
    }

    /**
     * Initializes the particle’s fade state and speed based on configuration.
     *
     * @param {HTMLElement} particle - The particle to configure.
     */
    init(particle) {
        particle.appearState = 0;

        const configs = getPluginConfigs();
        particle.appearSpeed = readRandomValue(configs.behavior_fade_speed || "4;0");
        particle.visibility = 1;
    }

    /**
     * Applies a fade-in or fade-out effect to the particle on each frame.
     *
     * Opacity is adjusted incrementally; particles are reset when fully faded out.
     *
     * @param {HTMLElement} particle - The particle element to animate.
     */
    animationStep(particle) {
        const opacity = parseFloat(particle.style.opacity);

        if (particle.appearState) {
            particle.visibility += 0.001 * particle.appearSpeed;

            if (opacity >= particle.startOpacity) {
                particle.appearState = 0;
            }
        } else {
            particle.visibility -= 0.001 * particle.appearSpeed;

            if (opacity <= 0) {
                // Reset to above the screen.
                this.startPosition.setStartPosition(particle);
                particle.appearState = 1;
            }
        }

        particle.style.opacity = particle.visibility * particle.startOpacity;
    }
}
