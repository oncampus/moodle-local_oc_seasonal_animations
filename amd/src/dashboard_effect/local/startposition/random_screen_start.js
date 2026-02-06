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
