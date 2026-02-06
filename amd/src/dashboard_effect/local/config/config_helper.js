/**
 * Computes a randomized numeric value based on the input configuration.
 *
 * Generates a number using a base constant and an optional random addition,
 * rounding the result if specified.
 *
 * @param {string} value - A string in the format "constant;random".
 * @param {boolean} [round=true] - Whether to round the output to two decimal places.
 * @returns {number} The resulting computed value.
 * @throws {Error} If the format is invalid or values are not numeric.
 */
export function readRandomValue(value, round = true) {
    if (!value.includes(';')) {
        throw new Error("Random value missing");
    }

    const parts = value.split(';');
    const constant = parseFloat(parts[0]);
    const random = parseFloat(parts[1]);

    if (isNaN(constant) || isNaN(random)) {
        throw new Error("Value can not be converted");
    }

    let outValue = Math.random() * random + constant;

    if (round) {
        outValue = Math.round(outValue * 100) / 100;
    }

    return outValue;
}

/**
 * Clamps a number to the min and max range derived from a random value string.
 *
 * The clamp range is defined by "constant;random", where min = constant
 * and max = constant + random.
 *
 * @param {number} clampMe - The value to clamp.
 * @param {string} randomValue - A string in the format "constant;random".
 * @returns {number} The clamped value.
 * @throws {Error} If the format is invalid or values are not numeric.
 */
export function clampByRandomValue(clampMe, randomValue) {
    if (!randomValue.includes(';')) {
        throw new Error("Random value missing");
    }

    const parts = randomValue.split(';');
    const constant = parseFloat(parts[0]);
    const random = parseFloat(parts[1]);

    if (isNaN(constant) || isNaN(random)) {
        throw new Error("Value can not be converted");
    }

    const min = constant;
    const max = constant + random;

    return Math.min(
        Math.max(clampMe, min),
        max
    );
}
