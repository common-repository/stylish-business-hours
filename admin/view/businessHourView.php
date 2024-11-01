<?php


// create object of langues class

$id = isset($_REQUEST['id']) ? sanitize_text_field($_REQUEST['id']) : '';
$id_shortcode = explode('_', $id);

// commented out due to throws error and variable is not being used
// $selected_icon = $datas->select_bhp_icon;

$days = $datas->days;

/*echo "<pre>";
print_r($datas);
echo "</pre>";*/
if ($datas->style != '' || $datas->style == 'style_business_3' || $datas->style == 'style_business_4' || $datas->style == 'style_business_9') { ?>
    <style>
        .display_alldays {
            display: none;
        }
    </style>
<?php }
if ($datas->style == 'style_business_1' || $datas->style == 'style_business_2' || $datas->style == 'style_business_5'  || $datas->style == 'style_business_6' || $datas->style == 'style_business_7'  || $datas->style == 'style_business_8') { ?>
    <style>
        .display_weekday {
            display: none;
        }

        .display_alldays {
            display: table-row;
        }
    </style>
<?php }
$item_icon_color = isset($datas->itemColor) ? $datas->itemColor : '000000';

$save = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'save');
$your_shortcode = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'your_shortcode');
$change_language = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'change_language');
$admin_setting = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'admin_setting');
$list_name = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'list_name');
$style = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'style');
$font_size = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'font_size');
$current_day_highlight_color = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'current_day_highlight_color');
$holiday_highlight_color = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'holiday_highlight_color');
$font_type = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'font_type');
$select_icon = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'select_icon');
$regular_business_hours = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'regular_business_hours');
$select_time_zone = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'select_time_zone');
$time_format = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'time_format');
$monday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'monday');
$tuesday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'tuesday');
$wednesday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'wednesday');
$thursday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'thursday');
$friday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'friday');
$saturday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'saturday');
$sunday = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'sunday');
$holidays_and_special_hours = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'holidays_and_special_hours');
$display = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'display');
$hours_before = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'hours_before');
$remove = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'remove');
$hours_after = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'hours_after');
$add = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'add');
$close = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'close');
$open = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'open');
$repeat_yearly = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'repeat_yearly');
$preview_list = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'preview_list');
$closed = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'closed');
$select_background_image = $this->change_lang_function(isset($_REQUEST['lang']) ? sanitize_text_field( $_REQUEST['lang'] ) : $datas->lang, 'select_background_image');

?>
<style>

</style>
<style id='spl-hide-menubar' type='text/css'>
		#adminmenumain, #wpfooter {
			display: none !important
		}
		#wpcontent {
			margin-left: 0 !important;
		}
</style>

<div class="container-fluid custom_business_hour_plugin" style="margin-bottom: 100px;">
    <input type="text" id="shortcode_id" value="<?php echo  esc_attr($id) ?>" hidden>
    <?php $this->get_header(); ?>
    <div class="row">
        <div class="col-7 left-content">
            <div class="row">
                <div class="col-10">
                    <input class="form-control custom-input shadow-sm" type="text" id="business_hour_name" value="<?php echo  esc_attr($datas->name) ?>" placeholder="<?php echo esc_attr($list_name) ?>">
                </div>
                <div class="col-2">
                    <button class="btn custom-button shadow-sm" id="shortcode_generate"><?php echo esc_attr($save) ?></button>
                </div>
            </div>
            <div class="row col-10 mx-0 mt-3 rounded-3 p-2 shadow-sm bg-white">
                <div class="col-6">
                    <label for=""><?php echo esc_attr($style) ?></label>
                </div>
                <div class="col-6">
                    <select name="" id="style_business">
                        <option <?php if ($datas->style == 'style_business_1') echo 'selected' ?> value="style_business_1">Style 1</option>
                        <option <?php if ($datas->style == 'style_business_2') echo 'selected' ?> value="style_business_2">Style 2</option>
                        <option <?php if ($datas->style == 'style_business_3') echo 'selected' ?> disabled value="style_business_3">Style 3 (Available in the Premium Version)</option>
                        <option <?php if ($datas->style == 'style_business_4') echo 'selected' ?> disabled value="style_business_4">Style 4 (Available in the Premium Version)</option>
                        <option <?php if ($datas->style == 'style_business_5') echo 'selected' ?> disabled value="style_business_5">Style 5 (Available in the Premium Version)</option>
                        <option <?php if ($datas->style == 'style_business_6') echo 'selected' ?> disabled value="style_business_6">Style 6 (Available in the Premium Version)</option>
                        <option <?php if ($datas->style == 'style_business_7') echo 'selected' ?> disabled value="style_business_7">Style 7 (Available in the Premium Version)</option>
                        <option <?php if ($datas->style == 'style_business_8') echo 'selected' ?> disabled value="style_business_8">Style 8 (Available in the Premium Version)</option>
                        <option <?php if ($datas->style == 'style_business_9') echo 'selected' ?> disabled value="style_business_9">Style 9 (Available in the Premium Version)</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <div class="row mt-4 align-items-center">
        <div class="col-4">
            <span class="sbh_menu">
                Business Hour Settings
            </span>
        </div>
    </div>
    <div class="row">
        <div class="col-7">
            <div class="settings-container mt-4" style="display: none;">
                <div class="p-4 shadow-sm bg-white rounded-3 mb-3">
                    <div class="row mb-4">
                        <div class="col-4">
                            <label for=""><?php echo esc_attr($change_language) ?></label>
                            <select name="" id="select_lang">
                                <option value="EN" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'EN' || $datas->lang == 'EN') echo "selected"; ?>>EN</option>
                                <option value="SP" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'SP' || $datas->lang == 'SP') echo "selected"; ?>>SP</option>
                                <option value="FR" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'FR' || $datas->lang == 'FR') echo "selected"; ?>>FR</option>
                                <option value="DE" <?php if (isset($_GET['lang']) && $_GET['lang'] == 'DE' || $datas->lang == 'DE') echo "selected"; ?>>DE</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <?php if (isset($id_shortcode[3]) ) : ?>
                            <div class="shortcode"><?php echo esc_attr($your_shortcode) ?> <br> <span>[stylish_business_hour id="<?php echo esc_attr($id_shortcode[3]) ?>"]</span></div>
                            <div class="shortcode"> <span>[stylish_business_hour type="status" id="<?php echo esc_attr($id_shortcode[3]) ?>"]</span></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="p-4 shadow-sm rounded-3 bg-white font-section">

                    <div class="row mb-4">

                        <div class="col-6">

                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    <label for=""><?php echo esc_attr($font_size) ?></label>
                                </div>
                                <div class="col-8">
                                    <select name="" id="" class="bhp_fontsize">
                                        <?php for ($i = 12; $i < 51; $i++) {
                                            if ( ! isset( $datas->fontSize ) ) continue; ?>
                                            <option <?php if ($datas->fontSize == $i . 'px') echo 'selected' ?> value="<?php echo intval($i) . 'px' ?>"><?php echo esc_attr($i) . 'px' ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-4">
                                    <label for="">Font Type</label>
                                </div>
                                <div class="col-8">
                                    <select name="" id="" class="bhp_fonttype w-100">
                                        <option value="0">Open sans</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                    <div class="col-6">
                            <div class="row">
                                <div class="col-7">
                                    <label for="">Current-Day Highlight Color</label>
                                </div>
                                <div class="col-4 colorpicker-container1">
                                    <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input id="current_day_color" class="colorpicker wp-color-picker" type="text" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-5">
                                    <label for="">Item Icon Color</label>
                                </div>
                                <div class="col-4 colorpicker-container2">
                                    <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input id="item_icon_color" class="colorpicker wp-color-picker" type="text" value="000000"></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                    <div class="col-6">
                            <div class="row">
                                <div class="col-7">
                                    <label for="">Holiday Highlight Color</label>
                                </div>
                                <div class="col-4 colorpicker-container3">
                                    <div class="wp-picker-container"><button type="button" class="button wp-color-result" aria-expanded="false"><span class="wp-color-result-text">Select Color</span></button><span class="wp-picker-input-wrap hidden"><label><span class="screen-reader-text">Color value</span><input id="jscolor_holiday_color" class="colorpicker wp-color-picker" type="text" value=""></label><input type="button" class="button button-small wp-picker-clear" value="Clear" aria-label="Clear color"></span><div class="wp-picker-holder"><div class="iris-picker iris-border" style="display: none; width: 255px; height: 202.125px; padding-bottom: 23.2209px;"><div class="iris-picker-inner"><div class="iris-square" style="width: 182.125px; height: 182.125px;"><a class="iris-square-value ui-draggable ui-draggable-handle" href="#" style="left: 0px; top: 182.125px;"><span class="iris-square-handle ui-slider-handle"></span></a><div class="iris-square-inner iris-square-horiz" style="background-image: -webkit-linear-gradient(left, rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255), rgb(255, 255, 255));"></div><div class="iris-square-inner iris-square-vert" style="background-image: -webkit-linear-gradient(top, rgba(0, 0, 0, 0), rgb(0, 0, 0));"></div></div><div class="iris-slider iris-strip" style="height: 205.346px; width: 28.2px; background-image: -webkit-linear-gradient(top, rgb(0, 0, 0), rgb(0, 0, 0));"><div class="iris-slider-offset ui-slider ui-corner-all ui-slider-vertical ui-widget ui-widget-content"><span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="bottom: 0%;"></span></div></div></div><div class="iris-palette-container"><a class="iris-palette" tabindex="0" style="background-color: rgb(0, 0, 0); height: 19.5784px; width: 19.5784px; margin-left: 0px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(255, 255, 255); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 51, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(221, 153, 51); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(238, 238, 34); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(129, 215, 66); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(30, 115, 190); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a><a class="iris-palette" tabindex="0" style="background-color: rgb(130, 36, 227); height: 19.5784px; width: 19.5784px; margin-left: 3.6425px;"></a></div></div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="days-container rounded-3 p-4 mt-4 shadow-sm bg-white">

                <h4>Regular Business Hours</h4>
                <div class="row" style="align-items: end;">
                    <div class="col-7">
                        <label for="">Select Time-Zone</label>
                        <select name="" id="" class="bs_custom_timezone w-100">
                            <?php
                            foreach ($timezone as $key => $data) : ?>
                                <option <?php if ($datas->timeZone == $key) echo 'selected' ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_attr($data) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="">Time Format</label>
                        <select name="" id="" class="bs_custom_timeformat">
                            <option <?php if ($datas->timeFormat == '12') echo 'selected' ?> value="12">12 Hour</option>
                            <option <?php if ($datas->timeFormat == '24') echo 'selected' ?> value="24">24 Hour</option>
                        </select>
                    </div>
                </div>
                <table class="form-table business_time_data">
                    <tbody>
                        <?php
                        $this->populateDaysTime($datas->days);
                        $this->populateDaysTime($datas->weekdays, true);
                        ?>
                    </tbody>
                </table>

            </div>
            <div class="holidays-container shadow-sm rounded-3 p-4 mt-4 bg-white">
                <h4>Holiday and Special hours</h4>
                <p class="add_holiday_ add_special_holiday">+ Add New Holiday or Special Hours</p>
                <div class="holidays_">
                    <table id="form-table" class="holidays_special_hours" style="font-size: 13px; width: 100%;">
                        <tbody>
                            <?php
                            // defining the $lang variable as it was not defined here
                            $lang = 'en';
                            if ( isset( $datas->holidays ) && is_array( $datas->holidays ) ) :
                                foreach ($datas->holidays as $key => $holiday) : ?>
                                    <tr>
                                        <td class="holiday_list date-td"><input class="holiday_dates" type="date" value="<?php echo esc_attr($holiday->date) ?>"></td>
                                        <td><input class="holiday_title" value="<?php echo esc_attr($holiday->title) ?>" type="text"></td>
                                        <td>
                                            <label class="switch <?php if ($holiday->status == 'open') echo 'checked' ?>">
                                                <input type="checkbox" class="timing2 holiday_status" <?php if ($holiday->status == 'open') echo 'checked' ?>>
                                                <div class="slider round"></div>
                                            </label>
                                            <span class="status"><?php echo $holiday->status == 'open' ? esc_attr(strtoupper($this->change_lang_function($lang, 'open'))) : esc_attr(strtoupper($this->change_lang_function($lang, 'close'))) ?></span>
                                        </td>
                                        <td><input class="special_time_picker_open same-time" placeholder="Open" value="<?php echo esc_attr($holiday->open) ?>"></td>
                                        <td><input class="special_time_picker_close same-time" placeholder="Close" value="<?php echo esc_attr($holiday->close) ?>"></td>
                                        <td><input id="yearly_checked" type="checkbox" <?php if ($holiday->repeat == 'true') echo 'checked' ?>> <label for="yearly_checked">Repeat Yearly</label> </td>
                                        <td><button class="rm_special_holiday">X</button></td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="holidays-advance rounded-3 p-3 mt-4">
                    <h4>Advance Options <i class="arrow_ down_"></i></h4>
                    <div class="holidays-advance-container" style="display: none;">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-check-label">
                                    <?php echo esc_attr($display); ?> <input class="hour_before" type="text" value="<?php echo esc_attr($datas->hBefore) ?>"> <?php echo esc_attr($hours_before); ?>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="form-check-label">
                                    <?php echo esc_attr($remove); ?> <input class="hour_after" type="text" value="<?php echo esc_attr($datas->hAfter) ?>"> <?php echo esc_attr($hours_after); ?>
                                </label>
                            </div>
                        </div>
                        <p>Enter hours for days when this bussines has an irregular schedule</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-5 mx-0 pe-4 mt-4">
            <div class="row">
                <h4>Preview List</h4>
            </div>
            <div class="row">
                <div class="preview shadow-sm bg-white rounded-3 p-3">

                </div>
            </div>
        </div>
    </div>

    <?php $this->get_footer() ?>

    <script>
        jQuery(document).ready(function($) {
            $("#style_business").change(function() {
                var selectedstyle = $("#style_business option:selected").val();
                if ($(this).val() == "style_business_1") $("#style_business_1").show();
                else $("#style_business_1").hide();
                if ($(this).val() == "style_business_2") $("#style_business_2").show();
                else $("#style_business_2").hide();
                if ($(this).val() == "style_business_3") $("#style_business_3").show();
                else $("#style_business_3").hide();
                if ($(this).val() == "style_business_4") $("#style_business_4").show();
                else $("#style_business_4").hide();
                if ($(this).val() == "style_business_5") $("#style_business_5").show();
                else $("#style_business_5").hide();
                if ($(this).val() == "style_business_6") $("#style_business_6").show();
                else $("#style_business_6").hide();
                if ($(this).val() == "style_business_7") $("#style_business_7").show();
                else $("#style_business_7").hide();
                if ($(this).val() == "style_business_8") $("#style_business_8").show();
                else $("#style_business_8").hide();
                if ($(this).val() == "style_business_9") $("#style_business_9").show();
                else $("#style_business_9").hide();
            });
            $('.sbh_menu').click(function() {
                $(this).toggleClass('active')
                if (!$('.settings-container').is(':visible')) {
                    $('.settings-container').slideToggle()
                } else {
                    $('.settings-container').slideToggle()
                }

            })
            $('.holidays-advance h4').click(function() {
                if ($('.holidays-advance-container').is(':visible')) {
                    $('.holidays-advance h4 i').removeClass('up_')
                    $('.holidays-advance h4 i').addClass('down_')
                } else {
                    $('.holidays-advance h4 i').removeClass('down_')
                    $('.holidays-advance h4 i').addClass('up_')
                }
                $('.holidays-advance-container').slideToggle()
                $(this).toggleClass('active')
            })



        });
    </script>