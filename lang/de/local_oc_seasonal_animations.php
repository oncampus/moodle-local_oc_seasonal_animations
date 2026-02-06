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

/**
 * Language strings for the local_eledia_snow_effect plugin.
 *
 * This file defines all interface texts, settings descriptions, and
 * configuration labels used throughout the seasonal effects plugin,
 * supporting the German locale.
 *
 * @package    local_eledia_snow_effect
 * @category   string
 * @author     Konrad Ebel <konrad.ebel@oncampus.de>
 * @copyright  2025, onCampus GmbH
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Saisonale Effekte';

$string['toggle_snowfall'] = 'Animationen umschalten';
$string['disable_snowfall'] = 'Animationen aus';
$string['enable_snowfall'] = 'Animationen an';
$string['min'] = 'min.';
$string['max'] = 'max.';

// Preview.
$string['preview:heading'] = 'Vorschau des saisonalen Effekts: {$a}';
$string['preview:title'] = 'Vorschau vom {$a}-Effekt';

// Einstellungskategorien.
$string['settings:seasonless'] = 'Ganzjährig';
$string['settings:spring'] = 'Frühling';
$string['settings:summer'] = 'Sommer';
$string['settings:autumn'] = 'Herbst';
$string['settings:winter'] = 'Winter';
$string['settings:enable'] = 'Aktiviert den saisonalen Effekt.';

// Uebersicht.
$string['settings:overview:preview'] = 'Vorschau';
$string['settings:overview:season_change_enabled'] = 'Saisonwechsel aktivieren';
$string['settings:overview:season_change_enabled_desc'] = 'Effekte automatisch je nach Jahreszeit wechseln. '
    . 'Die Einstellungen für Frühling, Sommer, Herbst und Winter werden verwendet.';

// Allgemeine Einstellungen.
$string['settings:general'] = 'Allgemein';
$string['settings:general:enabled'] = 'Effekte aktivieren';
$string['settings:general:enabled_desc'] = 'Aktivieren oder deaktivieren Sie den saisonalen Effekt.';
$string['settings:general:particle_count'] = 'Anzahl der Partikel';
$string['settings:general:particle_count_desc'] = 'Anzahl der Partikel, die auf dem Bildschirm angezeigt werden.';
$string['settings:general:start_position'] = 'Startpositionstyp';
$string['settings:general:start_position_desc'] = 'Wählen Sie, wie Partikel beim Erstellen positioniert werden.';
$string['settings:general:start_random'] = 'Zufälliger Start';
$string['settings:general:start_random_desc'] = 'Partikel direkt verteilt erscheinen lassen. Überschreibt die Startposition beim ersten Start.';
$string['settings:general:start_position:anchor'] = 'Anker';
$string['settings:general:start_position:random'] = 'Zufällig';
$string['settings:general:behavior'] = 'Partikelverhalten';
$string['settings:general:behavior_desc'] = 'Wählen Sie das Verhalten der Partikel.';
$string['settings:general:behavior:move'] = 'Bewegung';
$string['settings:general:behavior:fade'] = 'Ausblenden';
$string['settings:general:particle_type'] = 'Partikeltyp';
$string['settings:general:particle_type_desc'] = 'Wählen Sie den visuellen Typ der Partikel.';
$string['settings:general:particle_type:image'] = 'Individuell';
$string['settings:general:particle_type:snow'] = 'Kreis';
$string['settings:general:layer'] = 'Z-Index Ebene';
$string['settings:general:layer_desc'] = 'CSS-Z-Index für den saisonalen Effekt. Verwenden Sie -1, um ihn hinter dem Inhalt zu platzieren. '
    . 'Warnung: Die Verwendung höherer Werte kann die Barrierefreiheit beeinträchtigen.';

// Schnee-Partikel.
$string['settings:snow_particle'] = 'Kreis-Partikel Einstellungen';
$string['settings:particle:snow:color'] = 'Kreisfarbe';
$string['settings:particle:snow:color_desc'] = 'Wählen Sie die Kreisfarbe.';

// Gemeinsame Partikel-Einstellungen.
$string['settings:particle:size'] = 'Größe';
$string['settings:particle:size_desc'] = 'Größenbereich der Partikel festlegen.';
$string['settings:particle:opacity'] = 'Transparenz';
$string['settings:particle:opacity_desc'] = 'Transparenzbereich der Partikel festlegen.';

// Bild-Partikel.
$string['settings:image_particle'] = 'Individuelle Partikel Einstellungen';
$string['settings:particle:image:image'] = 'Partikelbild';
$string['settings:particle:image:image_desc'] = 'Laden Sie ein Bild hoch, das als Partikel verwendet wird.';

// Verhalten: Bewegung.
$string['settings:move_behavior'] = 'Bewegungsverhalten Einstellungen';
$string['settings:behavior:move:border'] = 'Randgrenze';
$string['settings:behavior:move:border_desc'] = 'Abstand vom Rand, bei dem Partikel zurückgesetzt werden.';
$string['settings:behavior:move:horizontal_speed'] = 'Horizontale Geschwindigkeit';
$string['settings:behavior:move:horizontal_speed_desc'] = 'Geschwindigkeitsbereich für horizontale Bewegung.';
$string['settings:behavior:move:vertical_speed'] = 'Vertikale Geschwindigkeit';
$string['settings:behavior:move:vertical_speed_desc'] = 'Geschwindigkeitsbereich für vertikale Bewegung.';
$string['settings:behavior:move:rotation_speed'] = 'Rotationsgeschwindigkeit';
$string['settings:behavior:move:rotation_speed_desc'] = 'Geschwindigkeitsbereich für Drehung.';
$string['settings:behavior:move:horizontal_random_change'] = 'Horizontale Geschwindigkeitsvariation';
$string['settings:behavior:move:horizontal_random_change_desc'] = 'Verändert die horizontale Geschwindigkeit bei jedem Tick zufällig.';
$string['settings:behavior:move:horizontal_random_span'] = 'Maximale horizontale Geschwindigkeitsabweichung';
$string['settings:behavior:move:horizontal_random_span_desc'] = 'Maximale horizontale Geschwindigkeit, die zufällig angewendet werden kann.';
$string['settings:behavior:move:vertical_random_change'] = 'Vertikale Geschwindigkeitsvariation';
$string['settings:behavior:move:vertical_random_change_desc'] = 'Verändert die vertikale Geschwindigkeit bei jedem Tick zufällig.';
$string['settings:behavior:move:vertical_random_span'] = 'Maximale vertikale Geschwindigkeitsabweichung';
$string['settings:behavior:move:vertical_random_span_desc'] = 'Maximale vertikale Geschwindigkeit, die zufällig angewendet werden kann.';

// Verhalten: Ausblenden.
$string['settings:fade_behavior'] = 'Ausblendverhalten Einstellungen';
$string['settings:behavior:fade:speed'] = 'Ein- / Ausblendgeschwindigkeit';
$string['settings:behavior:fade:speed_desc'] = 'Geschwindigkeit des Ein- und Ausblendens als Prozentsatz der Sichtbarkeit pro Tick.';

// Startposition: Anker.
$string['settings:anchor_start'] = 'Anker Startposition Einstellungen';
$string['settings:startpos:anchor:bordersite'] = 'Seiten für Startposition';
$string['settings:startpos:anchor:bordersite_desc'] = 'Wählen Sie, an welchen Rändern Partikel erscheinen sollen.';
$string['settings:startpos:anchor:bordersite:t'] = 'Oben';
$string['settings:startpos:anchor:bordersite:b'] = 'Unten';
$string['settings:startpos:anchor:bordersite:l'] = 'Links';
$string['settings:startpos:anchor:bordersite:r'] = 'Rechts';
$string['settings:startpos:anchor:distance'] = 'Abstand vom Anker';
$string['settings:startpos:anchor:distance_desc'] = 'Abstand in Pixeln von der gewählten Seite.';

// Startposition: Zufällig.
$string['settings:random_start'] = 'Zufällige Startposition Einstellungen';

// Validation.
$string['validate:max'] = 'Der Wert darf höchstens {$a} sein';
$string['validate:min'] = 'Der Wert muss mindestens {$a} sein';
