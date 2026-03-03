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

import {get_strings as getStrings} from 'core/str';

/**
 * Represents a button to toggle behavior.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

export class EffectToggleButton {
    /**
     * Create a new effect toggle button
     *
     * @param {Element} buttonElement Button element
     * @param {CallableFunction} enableCallback Callback to enable effect
     * @param {CallableFunction} disableCallback Callback to disable effect
     * @param {string} disableText Text to disable the button “Disable effect”
     * @param {string} enableText Text to enable the button “Enable effect”
     * @param {bool} isActive Whether the button starts active
     */
    constructor(
        buttonElement,
        enableCallback,
        disableCallback,
        disableText,
        enableText,
        isActive
    ) {
        this.buttonElement = buttonElement;
        this.disableText = disableText;
        this.enableText = enableText;
        this.isActive = isActive;
        this.enableCallback = enableCallback;
        this.disableCallback = disableCallback;
        this.updateText();
    }

    /**
     * Initialize the event listeners
     */
    initializeCallbacks() {
        this.buttonElement.addEventListener('click', (e) => {
            e.preventDefault();
            if (this.isActive) {
                this.disable();
            } else {
                this.enable();
            }
        });
    }

    /**
     * Enable the button
     */
    enable() {
        this.isActive = true;
        this.updateText();
        this.enableCallback();
    }

    /**
     * Disable the button
     */
    disable() {
        this.isActive = false;
        this.updateText();
        this.disableCallback();
    }

    /**
     * Creates a toggle button with texts
     *
     * @param {bool} active Whether the button starts active
     * @param {CallableFunction} enableCallback Callback to enable effect
     * @param {CallableFunction} disableCallback Callback to disable effect
     * @returns {Promise<EffectToggleButton>}
     */
    static async createAnimationToggleButton(active, enableCallback, disableCallback) {
        const toggleBtn = document.getElementById('snowfall-toggle-btn');
        if (!toggleBtn) {
            throw new Error("snowfall-toggle-btn identifier not found");
        }

        const [disableText, enableText] = await getStrings([
            {
                key: 'disable_snowfall',
                component: 'local_oc_seasonal_animations'
            },
            {
                key: 'enable_snowfall',
                component: 'local_oc_seasonal_animations'
            }
        ]);
        return new EffectToggleButton(toggleBtn, enableCallback, disableCallback, disableText, enableText, active);
    }

    /**
     * Sets the text content of the toggle button based on the active state.
     */
    updateText() {
        if (this.isActive) {
            this.buttonElement.textContent = this.disableText;
        } else {
            this.buttonElement.textContent = this.enableText;
        }
    }
}
