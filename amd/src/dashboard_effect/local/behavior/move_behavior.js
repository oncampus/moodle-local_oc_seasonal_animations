/**
 * Implements a movement behavior for particles with optional randomness.
 *
 * Particles move with constant speeds and sinusoidally varying random adjustments.
 * Rotation and border-based respawning are also supported.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

import {getPluginConfigs} from "../../../dashboard_effect";
import {clampByRandomValue, readRandomValue} from "../config/config_helper";

export class MoveBehavior {
    /**
     * Initializes the MoveBehavior with configuration and sets up boundary border.
     *
     * @param {Object} startPosition - Strategy used for repositioning particles.
     */
    constructor(startPosition) {
        this.startPosition = startPosition;
        const configs = getPluginConfigs();
        this.border = parseFloat(configs.behavior_move_border) || 0;
    }

    /**
     * Initializes particle movement parameters like speed, angle, and sinusoidal seeds.
     *
     * @param {HTMLElement} particle - The particle element to configure.
     */
    init(particle) {
        const configs = getPluginConfigs();
        particle.horizontalSpeed = readRandomValue(configs.behavior_move_horizontal_speed || "0;0");
        particle.verticalSpeed = readRandomValue(configs.behavior_move_vertical_speed || "2;2");
        particle.rotationSpeed = readRandomValue(configs.behavior_move_rotation_speed || "0;0");
        particle.rotationAngle = 0;
        particle.randomHorizontalSpeed = 0;
        particle.randomVerticalSpeed = 0;
        particle.age = 0;
        particle.seedX = Math.random() * 100000;
        particle.seedY = Math.random() * 100000;
    }

    /**
     * Updates the particle’s position and rotation on each animation frame.
     *
     * If a particle exits the screen (plus border margin), it is repositioned.
     * Otherwise, speed values are adjusted using sinusoidal functions and applied.
     *
     * @param {HTMLElement} particle - The particle element to animate.
     */
    animationStep(particle) {
        const computedStyle = window.getComputedStyle(particle);
        const top = parseFloat(computedStyle.top || "0");
        const left = parseFloat(computedStyle.left || "0");

        if (
            top > window.innerHeight + this.border
            || top < -this.border
            || left > window.innerWidth + this.border
            || left < -this.border
        ) {
            this.startPosition.setStartPosition(particle);
        } else {
            const configs = getPluginConfigs();

            let random = Math.sin(particle.age / 60 + particle.seedX);
            particle.randomHorizontalSpeed = random * configs.behavior_move_horizontal_random_change || 0;
            particle.randomHorizontalSpeed = clampByRandomValue(
                particle.randomHorizontalSpeed,
                configs.behavior_move_horizontal_random_span || "0;0"
            );

            random = Math.sin(particle.age / 60 + particle.seedY);
            particle.randomVerticalSpeed = random * configs.behavior_move_vertical_random_change || 0;
            particle.randomVerticalSpeed = clampByRandomValue(
                particle.randomVerticalSpeed,
                configs.behavior_move_vertical_random_span || "0;0"
            );
            particle.age += 1;

            particle.style.left = `${left + particle.horizontalSpeed + particle.randomHorizontalSpeed}px`;
            particle.style.top = `${top + particle.verticalSpeed + particle.randomVerticalSpeed}px`;
            particle.rotationAngle += particle.rotationSpeed;

            particle.style.transform = `rotate(${particle.rotationAngle}deg)`;
        }
    }
}
