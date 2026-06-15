# Session-Handoff: Salesforce-Einführung NovumState

> Diesen Text in eine neue Session einfügen, um nahtlos weiterzuarbeiten.

## Kontext & Ziel
Truong (NovumState) bereitet eine **Einführungssession für Salesforce (SF)** vor, um
Mitarbeiter:innen (MAs) für SF zu begeistern. Es sollen vier Themen vermittelt werden:

1. **Zentrale Ablage** – Digitalisierung & Speicherung von Verträgen, Dokumenten, Kontakten
2. **Vorgänge** – Dokumentation, Bearbeitung & Organisation von Vorgängen (Cases)
3. **Zusammenarbeit** – interne Kommunikation über Posts (Chatter) & Aufgaben
4. **Rechnungsfreigabe** – Freigabe von Rechnungen direkt in SF

Daraus sind nacheinander entstanden: ein **Agenda-Konzept**, eine **interaktive 4-Themen-Demo**
und – als Hauptdeliverable – eine **interaktive Simulation der SF-Case-Seite** plus eine
**Portal-Kachel**.

## Branch
Alle Arbeit liegt auf: **`claude/salesforce-intro-agenda-p55odf`**
Repo: `htruongnguyen92-prog/openai-chatkit`

## Erstellte Dateien

| Datei | Zweck | Status |
|---|---|---|
| `docs/salesforce-einfuehrung-agenda.md` | Konzept + 90-Min-Agenda für die Session, inkl. Checkliste & E-Mail-Entwurf an „Tim" | fertig |
| `demo/sf-einfuehrung.html` | Interaktive 4-Themen-Demo (SF-Lightning-Look), geführte Tour mit Spotlight, Tabs: Kunde / Vorgänge / Zusammenarbeit / Rechnungsfreigabe; reine HTML, offline lauffähig | fertig |
| `demo/Salesforce-intro.php` | **Hauptdeliverable**: interaktiver Rundgang über die SF-Case-Seite. Beim Weiterklicken wird je ein Element hervorgehoben (Spotlight + Abdunklung), rechts kurze Erklärung. 8 Schritte. Schritt-Inhalte serverseitig im PHP-`$steps`-Array, Anbindung über `data-step`-Attribute. Soll nach `sf-dashboards/` | fertig |
| `demo/_kachel-salesforce-intro.html` | Fertiges Kachel-Snippet (Stil der „Knowledge Base"-Karten: blauer Rahmen, ☁️-Icon, Badge „Alle") für den `MITARBEITER-PORTAL`-Grid, verlinkt auf `Salesforce-intro.php` | fertig |

## Wichtige Rahmenbedingungen / gelernte Fakten
- Die NovumState-Seiten (`https://future.novumstate.io/sf-dashboards/...`) liegen **hinter
  Login (HTTP 403)** und sind weder per WebFetch abrufbar noch im Repo vorhanden.
- Referenz-Demos, an denen sich Truong orientiert (nicht abrufbar):
  - `future.novumstate.io/sf-dashboards/re-demo.html`
  - `future.novumstate.io/sf-dashboards/knowledge.php?article=sf-uebersicht`
- Die echte Portal-Seite heißt **`novumstate-platform.php`** und enthält den
  `MITARBEITER-PORTAL`-Grid mit Karten: *MA-Portal Administration, MA-Portal
  Mitarbeiter-Ansicht, Knowledge Base, Knowledge Base Editor* (Badges: Admin/Extern/Alle/Team,
  Knowledge-Karten mit blauem Rahmen). Diese Datei liegt nur auf dem Server.
- Umgebung hier: PHP-CLI vorhanden (`php -l` läuft), **kein Headless-Browser** → keine
  Screenshots möglich.
- Design-Sprache der Simulationen: Salesforce-Lightning-Look (Navy-Header `#16325c`,
  Blau `#0070d2`, Hintergrund `#f3f2f2`). Beispiel-Case durchgängig: **Wasserschaden
  Lindenstr. 12**, Kunde „Mustermann Immobilien GmbH".

## Offener Punkt / nächster Schritt
- Die **Kachel** wurde noch **nicht direkt** in `novumstate-platform.php` eingebaut, weil die
  Datei nicht zugänglich ist. Zwei Optionen:
  1. Truong kopiert den HTML-Block des `MITARBEITER-PORTAL`-Grids in die Session →
     Kachel wird pixelgenau mit den echten CSS-Klassen eingefügt.
  2. Truong fügt das Snippet aus `demo/_kachel-salesforce-intro.html` selbst ein.
- Optionale Wünsche, noch offen: echte **NovumState-Farben/Logo** einbauen; Inhalte mit
  **echten Cases** befüllen (sobald „Tim" sie weiterleitet); Verlinkung/Integration der
  4-Themen-Demo (`sf-einfuehrung.html`) am Ende des Rundgangs.

## Git-Hinweise
- Entwicklung & Push ausschließlich auf `claude/salesforce-intro-agenda-p55odf`.
- Keine PRs ohne ausdrückliche Aufforderung.
