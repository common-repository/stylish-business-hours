<?php
class DF_SBH_DataController
{
    private $prefix = 'stylish_business_hour2_';
    function create(array $data)
    {
        $id = $this->prefix . time();
        update_option( $id, $data );
        return $id;
    }

    function read(string $id = null)
    {
        $cats_data = array();
        $is_list_page = false;
        if ($id == null) :
            global $wpdb;
            $option_names = $wpdb->get_results("SELECT * FROM $wpdb->options WHERE option_name LIKE '$this->prefix%'");
            foreach ($option_names as $opt) {
                $option = get_option($opt->option_name);
                $id_data = explode('_', $opt->option_name);

                $cat                          = new stdClass();
                $cat->id                      = $opt->option_name;
                $cat->shortcode               = '[stylish_business_hour id="' . $id_data[count($id_data) - 1] . '"]';
                $option_value                 = get_option( $cat->id );
                $listname                     = (object) $option_value;
                $cat->list_name               = $listname->name;
                $cats_data[$opt->option_name] = $cat;
                $is_list_page                 = true;
                // delete_option($opt->option_name);
            }
        else :
            $cats_data = get_option($id);
        endif;
        if ( $is_list_page ) {
            return $cats_data;
        }
        if ( empty( $cats_data ) ) {
            $cats_data = [
                "isEmpty" => true,
                "lang" => "EN",
                "name" => "New Business Hour",
                "style" => "style_business_1",
                "timeZone" => "Europe/Amsterdam",
                "timeFormat" => "12",
                "hBefore" => "3",
                "hAfter" => "5",
                "days" => [
                    0 => [
                        "day" => "Monday",
                        "status" => "open",
                        "open" => "8:30 AM",
                        "close" => "5:00 PM",
                    ],
                    1 => ["day" => "Tuesday", "status" => "close"],
                    2 => ["day" => "Wednesday", "status" => "close"],
                    3 => ["day" => "Thursday", "status" => "close"],
                    4 => ["day" => "Friday", "status" => "close"],
                    5 => ["day" => "Saturday", "status" => "close"],
                    6 => ["day" => "Sunday", "status" => "close"],
                ],
                "weekdays" => [
                    0 => [
                        "day" => "Monday - Friday",
                        "status" => "open",
                        "open" => "9:00 AM",
                        "close" => "5:00 PM",
                    ],
                    1 => ["day" => "Saturday", "status" => "close"],
                    2 => ["day" => "Sunday", "status" => "close"],
                ],
            ];
        }
        $cats_data = ! is_array( $cats_data ) ? json_decode( $cats_data ) : $cats_data;
        if ( is_array( $cats_data ) ) {
            $cats_data = (object) $cats_data;
        }
        $cats_data->holidays = isset( $cats_data->holidays ) ? $cats_data->holidays : array();
        // start of converting arrays to stabdard objects
		$cats_data->days = array_map( function ($d) {
			return (object) $d;
		}, $cats_data->days );
		$cats_data->holidays = array_map( function ($d) {
			return (object) $d;
		}, $cats_data->holidays );
		$cats_data->weekdays = array_map( function ($d) {
			return (object) $d;
		}, $cats_data->weekdays );
		// end of converting arrays to stabdard objects
        return $cats_data;
    }
    function update(string $id,array $data): string
    {
        update_option( $id, $data );
        return $id;
    }
    function delete(string $option_name): bool
    {
        return delete_option($option_name);
    }
}
