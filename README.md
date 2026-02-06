# Saisonale Effekte

Saisonale Effekte ist ein **lokales Plugin** für Moodle, welches animierte visuelle Partikeleffekte (z. B. Schnee, Blätter, Sonnenstrahlen) auf Startseite und Dashboard anzeigt. Es kann sich automatisch an die Jahreszeit anpassen oder manuell konfiguriert werden.

## Features

- Automatische visuelle Effekte je nach Jahreszeit (Frühling, Sommer, Herbst, Winter)
- Zwei Partikeltypen: Schneepunkte oder benutzerdefinierte Bilder
- Zwei Animationsmodi: Bewegung (inkl. Rotation) oder Ein-/Ausblenden
- Konfigurierbare Partikeleigenschaften wie Anzahl, Größe, Farbe, Geschwindigkeit
- Umschaltknopf zur Aktivierung/Deaktivierung der Effekte je Nutzer

## Installation

1. Klone das Repository in das Verzeichnis:
```
/local/oc_seasonal_animations
```
2. Rufe `Website-Administration` auf oder führe:
```
php admin/cli/upgrade.php
```
aus, um die Installation abzuschließen.

## Voraussetzungen

Keine externen Abhängigkeiten.

## Konfiguration
Nach der Installation ist das Plugin über folgenden Pfad konfigurierbar:

    Website-Administration → Plugins → Lokale Plugins → Saisonale Effekte

Das Plugin bietet für jede Jahreszeit eine eigene Einstellungsseite:
- Ganzjährig (Seasonless)
- Frühling (Spring)
- Sommer (Summer)
- Herbst (Autumn)
- Winter (Winter)
Dort können jeweils eigene Werte für Verhalten, Partikel und Darstellung festgelegt werden.

Zudem gibt es eine globale Option:
- Saisonwechsel aktivieren: Wechselt die aktive Jahreszeit automatisch basierend auf dem Monat.

### Allgemein
- Effekte aktivieren: Schaltet den Effekt für die jeweilige Saison ein oder aus.
- Partikelanzahl: Anzahl der gleichzeitig sichtbaren Partikel.
- Partikeltyp: Auswahl zwischen Bild oder Schnee.
- Startposition: Zufällige Position oder von einem Ankerpunkt am Rand.
- Verhalten: Partikel bewegen sich (inkl. Rotation) oder blenden ein/aus.
- Z-Index Ebene: Definiert, ob Partikel vor oder hinter anderen Inhalten erscheinen.

Bild-Partikel
- Bild hochladen: Eigene PNG-, JPG- oder GIF-Datei als Partikelbild verwenden.
- Größe: Zufälliger Bereich (min/max), z. B. 10;50.
- Transparenz: Bereich für Start-Opacity der Partikel.

Schnee-Partikel
- Farbe: Hex-Wert für Schneefarbe (z. B. #ffffff).
- Größe: Zufälliger Bereich.
- Transparenz: Starttransparenz zwischen 0 und 1.

Bewegungsverhalten
- Randgrenze: Abstand vom Rand, ab dem Partikel neu positioniert werden.
- Horizontale & Vertikale Geschwindigkeit: Basisbewegung in Pixel pro Frame.
- Rotationsgeschwindigkeit: Drehrate in Grad.
- Zufällige Variationen: Sinusbasierte Geschwindigkeitsmodifikatoren.

Fade-Verhalten
- Fade-Geschwindigkeit: Geschwindigkeit des Ein-/Ausblendens pro Frame.

Anker-Startposition
- Startseiten: Definiert, an welchen Bildschirmrändern Partikel erscheinen.
- Abstand vom Rand: Bereich in Pixeln vom Rand zur Startposition.

## Nutzung

Das Plugin ist aktiv auf:

- **Startseite** (`site-index`)
- **Dashboard** (`my-index`)

Ein Button zur Togglen der Animation wird eingeblendet. Nutzer können Animationen für ihre Session deaktivieren.

### Saisonvorschau

Admin-Vorschau eines bestimmten Saisontyps:
```
/local/local_oc_seasonal_animations/preview.php?season=winter_
```

Verfügbare Werte: `seasonless_`, `spring_`, `summer_`, `autumn_`, `winter_`

## Rechte

Kein Vorhanden.

## Cronjobs

Keine Vorhanden

## Web Services

Keine Vorhanden

## Lizenz

Dieses Plugin ist lizensiert unter der [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl.html).

## Credits

**Autor**: Konrad Ebel (konrad.ebel@oncampus.de)  
**© 2025**, onCampus GmbH

