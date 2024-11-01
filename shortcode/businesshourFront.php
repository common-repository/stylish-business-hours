<?php

class DF_SBH_shortcode
{
	function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'get_time_zone_user'));
		add_shortcode('stylish_business_hour', array($this, 'business_hour_plugin_data'));
	}
	function get_time_zone_user($hook)
	{
		wp_register_script('getUserTime_data', DF_SBH_URL . 'assets/js/businesshourFront.js', array('jquery'), '1.0', true);
	}

	function output_template( $data_array )
	{
		$data_array->fontFamily = 'inherit';
		$fontA = array();

		$hours_array = array();
		$current_day_col = isset( $data_array->currentColor ) ? $data_array->currentColor : '';
		$holiday_day_col = isset( $data_array->holidayColor ) ? $data_array->holidayColor : '';
		/***************************Get current weeks all date****************************************/
		date_default_timezone_set($data_array->timeZone);
		$monday = strtotime("last monday");
		$monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;
		$tuesday = strtotime(date("Y-m-d", $monday) . " +1 days");
		$wednesday = strtotime(date("Y-m-d", $monday) . " +2 days");
		$thusday = strtotime(date("Y-m-d", $monday) . " +3 days");
		$friday = strtotime(date("Y-m-d", $monday) . " +4 days");
		$saturday = strtotime(date("Y-m-d", $monday) . " +5 days");
		$sunday = strtotime(date("Y-m-d", $monday) . " +6 days");

		$mon = date("Y-m-d", $monday);
		$tue = date("Y-m-d", $tuesday);
		$wed = date("Y-m-d", $wednesday);
		$thu = date("Y-m-d", $thusday);
		$fri = date("Y-m-d", $friday);
		$sat = date("Y-m-d", $saturday);
		$sun = date("Y-m-d", $sunday);
		$current_week_date = array($mon, $tue, $wed, $thu, $fri, $sat, $sun);
		
		$html = '';
		if ($current_day_col != '') {
?>
			<style type='text/css'>
				.current_day {
					color: <?php echo esc_attr($current_day_col) ?> !important;
				}
			</style>
		<?php
		}
		if ($holiday_day_col != '') {
		?>
			<style type='text/css'>
				.holidays {
					color: <?php echo esc_attr($holiday_day_col) ?> !important;
				}
			</style>
		<?php
		}

		$selected_view = $data_array->style;
		$days = $data_array->days;
		$weekdays = $data_array->weekdays;
		$holiday_days = isset( $data_array->holidays ) ? $data_array->holidays : array();

		// start of converting arrays to stabdard objects
		$days = array_map( function ($d) {
			return (object) $d;
		}, $days );
		$holiday_days = array_map( function ($d) {
			return (object) $d;
		}, $holiday_days );
		$weekdays = array_map( function ($d) {
			return (object) $d;
		}, $weekdays );
		// end of converting arrays to stabdard objects

		/***************Get holidays day from holidays date**********************/
		// $holiday_days = !is_array($holiday_days) ? array() : $holiday_days;

		foreach ($holiday_days as $key => $val) {
			if (in_array($val->date, $current_week_date)) {
				$holiday[] = date('l', strtotime($val->date));
			}
		}

		/***************End get holidays day from holidays date******************/
		// $days = !is_array($days) ? array() : $days;
		$current_day = date('l');
		$html = '';
		foreach ($days as $key => $val) {
			if ( ! isset( $val->open ) ) $val->open = null;
			if ( ! isset( $val->close ) ) $val->close = null;
			if ($val->status == 'open') $hours_array[] = abs(strtotime($val->open) - strtotime($val->close)) / 3600;
			$val->hourDiff = abs(strtotime($val->open) - strtotime($val->close)) / 3600;
		}

		if (!empty($hours_array)) {
			$maximumhours = max($hours_array);
		}
		switch ($selected_view) {
			case 'style_business_1':
				$html = '<div class="office-hours custom-sbh">' .
					'<table class="custom-border">' .

					'<thead><th><span class="style_heading listing_type_1"></span></th></thead>' .
					'<tbody>';
				foreach ($days as $key => $val) {
					if (isset($val->day, $holiday) && in_array($val->day, $holiday)) {
						$holidays_class = "holidays";
						foreach ($data_array->holidays as $dd) {
							$day_name = date("l", strtotime($dd->date));
							if ($val->day == $day_name) {
								$date = date("l F d,", strtotime($dd->date));
								$notice = "<p>Attention: " . $date . " is a holiday and the business hours will be $dd->open to $dd->close.</p>";
							}
						}
					} else {
						$holidays_class = "";
						$notice = "";
					}
					if ($val->day == $current_day) {
						$current_dayclass = "current_day";
					} else {
						$current_dayclass = "";
					}
					if ($val->status == 'open') {
						$html .=  '<tr class="bottom-border ' . $current_dayclass . ' ' . $holidays_class . '"><td><strong>' . $this->change_lang_function($data_array->lang, $val->day) . '</strong><span>' . $val->open . ' - ' . $val->close . ' <br> ' . $notice . '</span></td></tr>';
					} else {
						$html .=  '<tr class="bottom-border ' . $current_dayclass . ' ' . $holidays_class . '"><td><strong>' . $this->change_lang_function($data_array->lang, $val->day) . '</strong><span>' . $this->change_lang_function($data_array->lang, 'closed') . ' <br> ' . $notice . '</span></td></tr>';
					}
				}
				$html .= '</tbody>' .
					'</table>' .
					'</div>';

				break;
			case 'style_business_2':
				$html = '<div class="second-design  custom-sbh">' .
					'<table>' .
					'<tbody>';
				foreach ($days as $key => $val) {
					if (isset($val->day, $holiday) && in_array($val->day, $holiday)) {
						$holidays_class = "holidays";
						$d = array_keys($holiday);
						foreach ($data_array->holidays as $dd) {
							$day_name = date("l", strtotime($dd->date));
							if ($val->day == $day_name) {
								$date = date("l F d,", strtotime($dd->date));
								$notice = "<p>Attention: " . $date . " is a holiday and the business hours will be $dd->open to $dd->close.</p>";
							}
						}
					} else {
						$holidays_class = "";
						$notice = "";
					}
					if ($val->day == $current_day) {
						$current_dayclass = "current_day";
					} else {
						$current_dayclass = "";
					}
					if ($val->status == 'open') {
						$html .= '<tr class="' . $holidays_class . '">' .
							'<td class="bottom-border ' . $current_dayclass . '">' . $this->change_lang_function($data_array->lang, $val->day) . '</td>' .
							' <td>' . $val->open . '</td>' .
							'<td>' . $val->close . '</td>' . $notice .
							'</tr>';
					} else {
						$html .= '<tr class="' . $holidays_class . '">' .
							'<td class="bottom-border ' . $current_dayclass . '">' . $this->change_lang_function($data_array->lang, $val->day) . '</td>' .
							' <td colspan="2" class="closed">' . $this->change_lang_function($data_array->lang, 'closed') . '</td>' . $notice .
							'</tr>';
					}
				}
				$html .= '</tbody>' .
					'</table>' .
					'</div>';

				break;
		}

		// 	foreach($days as $key=>$val){
		// 		$classes = $key.'_colorStyle';
		// 		$html.='<ul><li class="'.$classes.'">'.$key.'</li><li>'.$val->open.'-'.$val->close.'</li></ul>';
		// 	}

		// echo $current_day;
		// die;

		if (isset($a['type']) && $a['type'] == 'status') $html = $this->getdd($days, $current_day, $data_array->lang);
		return $html;
	}

	function business_hour_plugin_data($atts)
	{
		wp_enqueue_style('sbh-list-style');
		// wp_enqueue_script('sbh_frontend');

		ob_start();
		$a = shortcode_atts(array(
			'id'  =>  '',
			'type' => ''
		), $atts);

		if ( ! is_admin() ) {
			$option_name = "stylish_business_hour2" . '_' . esc_attr( $a['id'] );
			$data = get_option( $option_name );
			$data_array = is_array( $data ) ? $data : json_decode( $data ) ;
			if ( is_array($data_array) ) {
				$data_array = ( object ) $data_array;
			}
		}
		wp_enqueue_script('getUserTime_data');

		if ( is_admin() ) {
			$data_array = json_decode(json_encode(unserialize($a['id'])));
		}

		/***************************End get current weeks all date************************************/
		echo $this->output_template($data_array);

		?>
		<!--Start dynamic css setting-->
		<style>
			.style_heading {
				
				text-transform: uppercase;
			}

			.style_heading.listing_type_3 {
				font-weight: bold;
			}

			.inner-progress {
				background-image: linear-gradient(to left, #c5c0e8 0, green 100%) !important;
			}

			/*.inner-progress {*/
			/*     background: # //php echo $data_array->item_icon_color ;
								*/
			/* }*/
		</style>
		<script>
			var title_name = '<?php echo esc_attr($data_array->name); ?>';
			if (document.querySelector('.listing_type_1')) document.querySelector('.listing_type_1').innerHTML = title_name;
			if (document.querySelector('.listing_type_3')) document.querySelector('.listing_type_3').innerHTML = title_name;
			if (document.querySelector('.listing_type_4')) document.querySelector('.listing_type_4').innerHTML = title_name;
			if (document.querySelector('.listing_type_5')) document.querySelector('.listing_type_5').innerHTML = title_name;
			if (document.querySelector('.listing_type_6')) document.querySelector('.listing_type_6').innerHTML = title_name;
			if (document.querySelector('.listing_type_7')) document.querySelector('.listing_type_7').innerHTML = title_name;
			if (document.querySelector('.listing_type_8')) document.querySelector('.listing_type_8').innerHTML = title_name;
			if (document.querySelector('.listing_type_9')) document.querySelector('.listing_type_9').innerHTML = title_name;
		</script>

<?php
		return ob_get_clean();
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

	function getdd(array $days, string $current, string $l): string
	{
		$status = 'close';
		foreach ($days as $d) {
			if ($d->day == $current) $status = $d->status;
		}
		$frase = $status == 'close' ? $this->change_lang_function($l, 'we_are_close') : $this->change_lang_function($l, 'we_are_open');
		return "<div class='sbh_one_line'> {$frase} </div>";
	}
}
$SBH_shortcode = new DF_SBH_shortcode();
