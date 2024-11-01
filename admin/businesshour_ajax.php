<?php

class DF_SBH_Ajax
{
    function __construct()
    {
        add_action("wp_ajax_set_business_hour_data", array($this, "set_business_hour_data"));
        add_action("wp_ajax_nopriv_set_business_hour_data", array($this, "set_business_hour_data"));
        add_action("wp_ajax_get_option_data", array($this, "get_option_data"));
        add_action("wp_ajax_nopriv_get_option_data", array($this, "get_option_data"));
        add_action("wp_ajax_showPreview", array($this, "showPreview"));
    }

    function showPreview()
    {
        check_ajax_referer('pageSbhs','nonce');
        $data = serialize($_POST);
        echo do_shortcode("[stylish_business_hour id='$data']");
        die();
    }

    function get_option_data()
    {
        function sbh_sanitize_text_or_array_field($array_or_string)
        {
            if (is_string($array_or_string)) {
                $array_or_string = sanitize_text_field($array_or_string);
            } elseif (is_array($array_or_string)) {
                foreach ($array_or_string as $key => &$value) {
                    if (is_array($value)) {
                        $value = sbh_sanitize_text_or_array_field($value);
                    } else {
                        $value = sanitize_text_field($value);
                    }
                }
            }
            return $array_or_string;
        }
        require_once dirname(__FILE__,1) . '/controllers/dataController.php';
        $dc = new DF_SBH_DataController();

        check_ajax_referer('pageSbhs','nonce');

        $dData = sbh_sanitize_text_or_array_field($_POST);

        $id = $dData['id'] != '' ? $dc->update($dData['id'], $dData) : $dc->create($dData);
        wp_send_json(array('id' => $id));
    }
}

$DF_SBH_Ajax = new DF_SBH_Ajax();
