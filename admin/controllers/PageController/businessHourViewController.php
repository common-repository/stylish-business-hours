<?php
class DF_SBH_BusinessHourViewController
{
    function __construct()
    {
        $timezone = array();
        $timezone = $this->generate_timezone_list();
        require_once dirname(__FILE__, 3) . '/controllers/dataController.php';
        $dc = new DF_SBH_DataController();
        $id = isset($_GET["id"]) ? sanitize_text_field( $_GET["id"] ) : 0;
        $datas = $dc->read($id);
        $this->style_scripts();
        wp_localize_script('sbh_backend', 'data', array('obj' => $datas, 'wnonce' => wp_create_nonce('pageSbhs')));
        require_once dirname(__FILE__, 3) . '/view/businessHourView.php';
    }

    function populateDaysTime($days, bool $weekday = false)
    {
        $lang = isset($_GET['lang']) ? sanitize_text_field( $_GET['lang'] ) : '';
        if (!is_array($days) && !$weekday) $days = json_decode('[{"day":"Monday"},{"day":"Tuesday"},{"day":"Wednesday"},{"day":"Thursday"},{"day":"Friday"},{"day":"Saturday"},{"day":"Sunday"}]');
        if (!is_array($days) && $weekday) $days = json_decode('[{"day":"Monday - Friday"},{"day":"Saturday"},{"day":"Sunday"}]');
        foreach ($days as $key => $day) :
?>
            <tr class="<?php echo $weekday ? 'display_weekday' : 'display_alldays' ?>">
                <th><?php echo esc_attr($this->change_lang_function($lang, strtolower($day->day)))  ?></th>
                <td class="">
                    <label class="switch <?php if ($day->status == 'open') echo 'checked' ?>">
                        <input type="checkbox" class="timing" <?php if ($day->status == 'open') echo 'checked' ?>>
                        <div class="slider round"></div>
                    </label>
                    <span class="status"><?php echo $day->status == 'open' ? esc_attr( strtoupper($this->change_lang_function($lang, 'open')) ) : esc_attr( strtoupper($this->change_lang_function($lang, 'close')) ) ?></span>
                </td>
                <?php if ($day->status == 'open') : ?>
                    <td class="timepickerday"><input class="timepicker_12_open timepicker_open" placeholder="Open" value="<?php echo esc_attr($day->open) ?>" autocomplete="off"></td>
                    <td class="timepickerday"><input class="timepicker_12_close timepicker_close" placeholder="Close" value="<?php echo esc_attr($day->close) ?>" autocomplete="off"></td>
                    <td class="timepickerday add_hours_bhp">
                        <!--<a href="javascript:void(0);" class="add_hours">ADD Hours</a>-->
                    </td>
                <?php endif ?>
            </tr>
<?php
        endforeach;
    }

    function style_scripts()
    {
        wp_enqueue_style('businessHour_admin_style');
        wp_enqueue_style('jstimepick_style');
        wp_enqueue_script('jslibrary');
        wp_enqueue_script('jstimepick');
        // wp_enqueue_script('businessHour_js');
        // wp_enqueue_script('moment');
        // new
        wp_enqueue_script('sbh_backend');
        wp_enqueue_style('sbh_bootstrap');
        wp_enqueue_script('sbh_bootstrap');
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_style('sbh-list-style');
    }

    function generate_timezone_list()
    {
        static $regions = array(
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        );

        $timezones = array();
        foreach ($regions as $region) {
            $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
        }

        $timezone_offsets = array();
        foreach ($timezones as $timezone) {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }

        // sort timezone by offset
        asort($timezone_offsets);

        $timezone_list = array();
        foreach ($timezone_offsets as $timezone => $offset) {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate('H:i', abs($offset));

            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }

        return $timezone_list;
    }

    function get_header()
    {
        require_once dirname(__FILE__, 3) . '/view/logo-header.php';
    }

    function get_footer()
    {
        require_once dirname(__FILE__, 3) . '/view/logo-footer.php';
    }

    function change_lang_function($lang, $keyword)
	{
		if ($lang == '') $lang = 'EN';
		$language = array(
			"save" => ["Save", "Salvar", "sauvegarder",  "Opslaan"],
			"your_shortcode" => ["Your Shortcode", "Su código corto", "Votre Shortcode", "Uw shortcode"],
			"change_language" => ["Change Language", "Cambiar idioma", "Changer de langue", "Wijzig taal"],
			"admin_setting" => ["Admin Setting", "Configuración del administrador", "Paramètre Admin", "Beheerinstelling"],
			"list_name" => ["List Name", "Lista de nombres", "Liste de noms", "Lijstnaam"],
			"style" => ["Style", "Estilo", "Style", "Lijstnaam"],
			"font_size" => ["Font size", "Tamaño de fuente", "Taille de police", "Lettertypegrootte"],
			"current_day_highlight_color" => ["Current-Day Highlight Color", "Color de resaltado del día actual", "Couleur du jour actuel", "Highlight-kleur huidige dag"],
			"holiday_highlight_color" => ["Holiday Highlight Color", "Color de resaltado de vacaciones", "Couleur des fêtes", "Vakantie markeer kleur"],
			"font_type" => ["Font type", "Tipo de fuente", "Type de police", "Lettertype"],
			"select_icon" => ["Select icon", "Seleccionar ícono", "Icône de sélection", "Selecteer een pictogram"],
			"regular_business_hours" => ["Regular Business Hours", "Horario comercial regular", "Heures d'ouverture régulières", "Reguliere openingstijden"],
			"select_time_zone" => ["Select Time-zone", "Selecciona la zona horaria", "Sélectionnez le fuseau horaire", "Selecteer Tijdzone"],
			"time_format" => ["Time Format", "Formato de tiempo", "Format de l'heure", "Tijd formaat"],
			"monday" => ["Monday", "lunes", "Lundi", "maandag"],
			"monday - friday" => ["Monday - Friday", "lunes - viernes", "Lundi - Vendredi", "maandag - vrijdag"],
			"tuesday" => ["Tuesday", "martes", "Mardi", "dinsdag"],
			"wednesday" => ["Wednesday", "miércoles", "Mercredi", "woensdag"],
			"thursday" => ["Thursday", "jueves", "Jeudi", "donderdag"],
			"friday" => ["Friday", "viernes", "Vendredi", "vrijdag"],
			"saturday" => ["Saturday", "sábado", "samedi", "zaterdag"],
			"sunday" => ["Sunday", "domingo", "dimanche", "zondag"],
			"holidays_and_special_hours" => ["Holidays and Special Hours", "Vacaciones y Horas Especiales", "Vacances et Heures Spéciales", "Feestdagen en speciale uren"],
			"display" => ["Display", "Monitor", "Afficher", "tonen"],
			"hours_before" => ["Hours before", "Horas antes", "Heures avant", "Uren eerder"],
			"remove" => ["Remove", "retirar", "Retirer", "Verwijderen"],
			"hours_after" => ["Hours after", "Horas despues", "Heures après", "Uren erna"],
			"add" => ["Add", "Añadir", "Ajouter", "Toevoegen"],
			"close" => ["Close", "Cerca", "Fermer", "Dichtbij"],
			"open" => ["Open", "Abierto", "Ouvrir", "Open"],
			"repeat_yearly" => ["Repeat Yearly", "Repita anualmente", "Répéter chaque année", "Herhaal elk jaar"],
			"preview_list" => ["Preview list", "Lista de vista previa", "Liste de prévisualisation", "Voorbeeldlijst"],
			"closed" => ["CLOSED", "CERRADO", "FERMÉ", "GESLOTEN"],
			"select_background_image" => ["Select Background Image", "Seleccionar imagen de fondo", "Sélectionner une image de fond", "Selecteer achtergrondafbeelding"],
			"we_are_close" => ["We are currently close", "Ahora estamos cerrados", "Nous sommes actuellement fermé", "Wir haben derzeit geschlossen"],
			"we_are_open" => ["We are currently open", "Ahora estamos abiertos", "Nous sommes actuellement ouvert", "Wir haben derzeit geöffnet"],
		);

		$v = 0;
		if ($lang == 'SP') $v = 1;
		if ($lang == 'FR') $v = 2;
		if ($lang == 'DE') $v = 3;
		return $language[strtolower($keyword)][$v];
	}
}
new DF_SBH_BusinessHourViewController();
