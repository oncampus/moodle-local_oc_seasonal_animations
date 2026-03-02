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
 * Provides a strategy to start particles at random screen positions.
 *
 * Positions each particle randomly within the visible screen area by
 * setting their `left` and `top` CSS properties using percentage values.
 *
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 */

export class RandomScreenStart {
    /**
     * Assigns a random position to the given particle within the screen bounds.
     *
     * @param {HTMLElement} particle - The particle element to position.
     */
    setStartPosition(particle) {
        const startSize = particle.startSize ?? 0;
        particle.style.left = `calc(${Math.random() * 100}% - ${startSize})`;
        particle.style.top = `calc(${Math.random() * 100}% - ${startSize})`;
    }
}
