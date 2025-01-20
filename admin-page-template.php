<div class="wrap">
    <h1>Simple Amazon Referral</h1>

	<h2>Modulbeschreibung</h2>
    <p>Mit diesem Modul können Sie Amazon-Produkte verwalten und auf Ihrer Website anzeigen. Nutzen Sie die folgenden Shortcodes, um Produkte in Beiträgen oder Seiten einzubinden:</p>
    <ul>
        <li><strong>[AMAZON_REF]Produkt-ID[/AMAZON_REF]</strong>: Zeigt ein Produkt mit dem Standard-Template an. Sie können optional das Template mit dem Attribut <code>template</code> anpassen, z. B. <code>[AMAZON_REF template="custom"]Produkt-ID[/AMAZON_REF]</code>.</li>
        <li><strong>[AMAZON_TXT title="Ihr Linktext"]Produkt-ID[/AMAZON_TXT]</strong>: Fügt einen Textlink ein, der auf das Produkt verweist. Der <code>title</code>-Parameter gibt den anzuzeigenden Linktext an.</li>
    </ul>
    <p>Die <strong>Produkt-ID</strong> kann entweder die technische ID aus der Datenbank oder die benutzerdefinierte Produkt-ID sein.</p>


    <h2><?php echo isset($_GET['edit']) ? 'Produkt bearbeiten' : 'Produkt hinzufügen'; ?></h2>
    <form method="post">
        <?php
        $edit_product = null;
        if (isset($_GET['edit'])) {
            $edit_id = (int) $_GET['edit'];
            $edit_product = $wpdb->get_row($wpdb->prepare("SELECT * FROM $this->table_name WHERE id = %d", $edit_id));
        }
        ?>
        <table class="form-table">
            <tr>
                <th><label for="product_id">Produkt-ID</label></th>
                <td><input type="text" name="product_id" id="product_id" required value="<?php echo $edit_product ? esc_attr($edit_product->product_id) : ''; ?>"></td>
            </tr>
            <tr>
                <th><label for="image_url">Bild-URL</label></th>
                <td><input type="url" name="image_url" id="image_url" required value="<?php echo $edit_product ? esc_url($edit_product->image_url) : ''; ?>"></td>
            </tr>
            <tr>
                <th><label for="title">Titel</label></th>
                <td><input type="text" name="title" id="title" required value="<?php echo $edit_product ? esc_attr($edit_product->title) : ''; ?>"></td>
            </tr>
            <tr>
                <th><label for="description">Beschreibung</label></th>
                <td><textarea name="description" id="description" rows="4"><?php echo $edit_product ? esc_textarea($edit_product->description) : ''; ?></textarea></td>
            </tr>
            <tr>
                <th><label for="product_url">Produkt-URL</label></th>
                <td><input type="url" name="product_url" id="product_url" required value="<?php echo $edit_product ? esc_url($edit_product->product_url) : ''; ?>"></td>
            </tr>
        </table>

        <input type="hidden" name="action" value="<?php echo $edit_product ? 'edit' : 'add'; ?>">
        <?php if ($edit_product) : ?>
            <input type="hidden" name="id" value="<?php echo esc_attr($edit_product->id); ?>">
        <?php endif; ?>
        <button type="submit" class="button button-primary">Produkt speichern</button>
    </form>

    <h2>Bestehende Produkte</h2>
    <table class="widefat fixed">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produkt-ID</th>
                <th>Bild-URL</th>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Produkt-URL</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($products)) : ?>
                <tr>
                    <td colspan="7">Keine Produkte vorhanden.</td>
                </tr>
            <?php else : ?>
                <?php foreach ($products as $product) : ?>
                    <tr>
                        <td><?php echo esc_html($product->id); ?></td>
                        <td><?php echo esc_html($product->product_id); ?></td>
                        <td><a href="<?php echo esc_url($product->image_url); ?>" target="_blank">Bild anzeigen</a></td>
                        <td><?php echo esc_html($product->title); ?></td>
                        <td><?php echo esc_html($product->description); ?></td>
                        <td><a href="<?php echo esc_url($product->product_url); ?>" target="_blank">Produkt-Link</a></td>
                        <td>
                            <a href="?page=simple-amazon-referral&edit=<?php echo esc_attr($product->id); ?>" class="button button-primary">Bearbeiten</a>
                            <a href="?page=simple-amazon-referral&action=delete&id=<?php echo esc_attr($product->id); ?>" class="button button-secondary" onclick="return confirm('Möchten Sie dieses Produkt wirklich löschen?');">Löschen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
