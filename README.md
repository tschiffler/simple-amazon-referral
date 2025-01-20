# Simple Amazon Referral

Simple Amazon Referral ist ein WordPress-Plugin, mit dem Amazon-Produkte einfach verwaltet und auf einer Website angezeigt werden können. Es bietet eine benutzerfreundliche Admin-Oberfläche und flexible Shortcodes zur Integration von Produkten in Beiträge und Seiten.

Die Daten der werden in einer neuen Datenbanktabelle gespeichert, um die Verwaltung von Produkten zu erleichtern. Die Anzeige der Produkte erfolgt über Shortcodes, die in den Inhalt eingefügt werden können. Das Modul hat keine Abhängigkeiten zu irgend welchen APIs, sämtliche Referal-Links werden manuell eingetragen.

## Funktionen

- **Produkte verwalten**: Hinzufügen, Bearbeiten und Löschen von Amazon-Produkten über das WordPress-Dashboard.
- **Shortcodes für die Integration**:
    - `[AMAZON_REF]Produkt-ID[/AMAZON_REF]`: Zeigt ein Produkt mit dem Standard-Template an. Optional kann ein benutzerdefiniertes Template angegeben werden: `[AMAZON_REF template="custom"]Produkt-ID[/AMAZON_REF]`.
    - `[AMAZON_TXT title="Linktext"]Produkt-ID[/AMAZON_TXT]`: Fügt einen Textlink zu einem Produkt ein.
- **Flexibilität**: Unterstützt sowohl benutzerdefinierte Produkt-IDs als auch technische Datenbank-IDs.
- **Einfache Anpassung**: Templates für die Produktanzeige können leicht erweitert oder angepasst werden.

## Installation

1. Lade die Dateien herunter oder klone das Repository:
   ```bash
   git clone https://github.com/tschiffler/simple-amazon-referral.git
   ```
2. Kopiere das Plugin-Verzeichnis in den WordPress-Plugin-Ordner:
   ```
   wp-content/plugins/
   ```
3. Aktiviere das Plugin im WordPress-Adminbereich.

## Verwendung

### Shortcodes

- **Produktanzeige**: `[AMAZON_REF]Produkt-ID[/AMAZON_REF]`
- **Textlink**: `[AMAZON_TXT title="Linktext"]Produkt-ID[/AMAZON_TXT]`

Die Produkt-ID kann entweder die technische ID aus der Datenbank oder die benutzerdefinierte Produkt-ID sein.

### Admin-Oberfläche

1. Öffne das Plugin über das WordPress-Admin-Menü.
2. Verwalte Produkte:
    - Hinzufügen: Fülle die Felder im Formular aus und speichere das Produkt.
    - Bearbeiten: Klicke auf "Bearbeiten", um bestehende Produkte anzupassen.
    - Löschen: Entferne Produkte aus der Liste.

## Verzeichnisstruktur

```plaintext
simple-amazon-referral/
├── templates/                     # Templates für die Produktanzeige
├── simple-amazon-referral.php     # Hauptdatei des Plugins
├── admin-page-template.php        # Template des Adminbereiches
└── README.md                      # Projektbeschreibung
```

## Lizenz

Dieses Plugin wird unter der [MIT-Lizenz](LICENSE) bereitgestellt. Sie können es frei verwenden, ändern und verteilen.

## Beitrag leisten

Beiträge sind willkommen! Erstellen Sie einfach einen Fork des Projekts, nehmen Sie Änderungen vor und senden Sie einen Pull Request.

---

### Vorschläge oder Probleme?
Eröffnen Sie ein [Issue](https://github.com/tschiffler/simple-amazon-referral/issues), um Feedback oder Fehler zu melden.
