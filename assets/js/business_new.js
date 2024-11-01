jQuery(document).ready(function ($) {

    let BusinesH = function () {

        this.$name = $('#business_hour_name')
        this.$style = $('#style_business')
        this.$timeZone = $('.bs_custom_timezone')
        this.$timeFormat = $('.bs_custom_timeformat')
        this.$hBefore = $('.hour_before')
        this.$hAfter = $('.hour_after')
        this.$lang = $('#select_lang')

        this.init = function () {
            
            this.create()

            setHour()
            
            handleHolidayClose()

            handleDays()

            toggleChange()

            loadPreview()

            document.querySelector('.left-content').addEventListener('change', function (e) {
                loadPreview()
            })
            document.querySelector('.settings-container').addEventListener('change', function (e) {
                loadPreview()
            })
            document.querySelector('.holidays-container').addEventListener('change', function (e) {
                loadPreview()
            })

        }

        this.create = function(){
            let over = document.createElement('div')
            over.setAttribute('id','oo')
            let p = document.createElement('p')
            p.innerHTML = 'You are using the <strong>Demo</strong> version of the plugin, Click <strong><a href="https://www.stylishpricelist.com/stylish-business-hours">here</a></strong> to buy a pro version'
            over.appendChild(p)
            document.querySelector('.font-section').appendChild(over)
        }

        this.get = function () {
            let getDays = function () {
                let days = []
                document.querySelectorAll('.display_alldays').forEach(function (ad, i) {
                    days.push({
                        day: i == 0 ? 'Monday' : i == 1 ? 'Tuesday' : i == 2 ? 'Wednesday' : i == 3 ? 'Thursday' : i == 4 ? 'Friday' : i == 5 ? 'Saturday' : i == 6 ? 'Sunday' : null,
                        status: ad.querySelector('.timing').checked ? 'open' : 'close',
                        open: ad.querySelector('.timepicker_open')?.value,
                        close: ad.querySelector('.timepicker_close')?.value
                    })
                });
                return days
            }
            let getDays2 = function () {
                let days = []
                document.querySelectorAll('.display_weekday').forEach(function (dw, i) {
                    days.push({
                        day: i == 0 ? 'Monday - Friday' : i == 1 ? 'Saturday' : i == 2 ? 'Sunday' : '',
                        status: dw.querySelector('.timing').checked ? 'open' : 'close',
                        open: dw.querySelector('.timepicker_open')?.value,
                        close: dw.querySelector('.timepicker_close')?.value
                    })
                });
                return days
            }
            let getHolidays = function () {
                let holidays = []
                document.querySelectorAll('tr > .holiday_list').forEach(e => {
                    let tr = e.closest('tr')
                    holidays.push({
                        date: tr.querySelector('.holiday_dates').value,
                        title: tr.querySelector('.holiday_title').value,
                        status: tr.querySelector('.holiday_status').checked ? 'open' : 'close',
                        open: tr.querySelector('.special_time_picker_open').value,
                        close: tr.querySelector('.special_time_picker_close').value,
                        repeat: tr.querySelectorAll('td')[5].querySelector('input').checked
                    })

                });
                return holidays
            }
            return {
                lang: this.$lang.val(),
                name: this.$name.val(),
                style: this.$style.val(),
                timeZone: this.$timeZone.val(),
                timeFormat: this.$timeFormat.val(),
                hBefore: this.$hBefore.val(),
                hAfter: this.$hAfter.val(),
                days: getDays(),
                weekdays: getDays2(),
                holidays: getHolidays()
            }
        }

    }

    let createHoliday = function () {
        let tr = document.createElement('tr')
        let html = `<td class="holiday_list date-td"><input class="holiday_dates" type="date" name="date"></td>
        <td><input class="holiday_title" name="holiday_title[]" value="" type="text"></td>
        <td>
            <label class="switch checked">
                <input type="checkbox" class="timing2 holiday_status" checked>
                <div class="slider round"></div>
            </label>
            <span class="status">OPEN</span>
        </td>
        <td><input autocomplete="off" class="special_time_picker_open same-time" name="special_time_picker_open" placeholder="Open"></td>
        <td><input autocomplete="off" class="special_time_picker_close same-time" name="special_time_picker_close" placeholder="Close"></td>
        <td><input id="yearly_checked" type="checkbox"> <label for="yearly_checked">Repeat Yearly</label></td>
        <td><button class="rm_special_holiday">X</button></td>`
        tr.innerHTML = html
        return tr
    }
    let createHours = function () {
        return `<td class="timepickerday"><input autocomplete="off" class="timepicker_12_open timepicker_open" name="timepicker_12_open[]" placeholder="Open" attr="Monday"></td>
        <td class="timepickerday"><input autocomplete="off" class="timepicker_12_close timepicker_close" name="timepicker_12_close[]" placeholder="Close" attr="Monday"></td>
        <td class="timepickerday add_hours_bhp"><!--<a href="javascript:void(0);" class="add_hours">ADD Hours</a>--></td>`
    }
    let setHour = function () {
        let format = document.querySelector('.bs_custom_timeformat').value
        let options = {
            timeFormat: format == '12' ? 'h:mm p' : 'HH:mm',
            interval: 30,
            minTime: '08',
            maxTime: '23',
            dynamic: !1,
            dropdown: !0,
            scrollbar: !0,
            change: loadPreview
        }
        jQuery('.timepicker_12_open').timepicker(options);
        jQuery('.timepicker_12_close').timepicker(options);
        jQuery('.special_time_picker_open').timepicker(options);
        jQuery('.special_time_picker_close').timepicker(options);
    }

    $('.timing').on('change', function () {
        let parent = $(this).closest('tr')
        if ($(this).prop('checked')) {
            $(parent).find('.td-btn-copy').remove()
            $(parent).append(createHours())
            setHour()
        } else {
            $(parent).find('.timepickerday').remove()
            if (document.querySelectorAll('.display_alldays')[0].closest('tr').querySelector('.timing').checked) $(parent).append(tdCopy())
        }
        loadPreview()
    })

    $('.timing2').change(function () {
        let parent = $(this).closest('tr')
        if ($(this).prop('checked')) {
            $(parent).find('.special_time_picker_open').removeAttr('disabled')
            $(parent).find('.special_time_picker_close').removeAttr('disabled')
            loadPreview()
        } else {
            $(parent).find('.special_time_picker_open').attr('disabled', 'true')
            $(parent).find('.special_time_picker_close').attr('disabled', 'true')
            loadPreview()
        }
    })

    document.querySelector('.custom_business_hour_plugin').addEventListener('change', function (e) {
        if (e.target.classList.contains('holiday_status')) {
            let parent = e.target.closest('tr')
            if (e.target.checked) {
                e.target.setAttribute('checked', true)
                parent.querySelector('.special_time_picker_open').removeAttribute('disabled')
                parent.querySelector('.special_time_picker_close').removeAttribute('disabled')

            } else {
                e.target.setAttribute('checked', false)
                parent.querySelector('.special_time_picker_open').setAttribute('disabled', 'true')
                parent.querySelector('.special_time_picker_close').setAttribute('disabled', 'true')
            }
        }
        if (e.target.id == 'style_business') {
            handleDays();
        }
    })
    let handleHolidayClose = function () {
        $('.holiday_status:not(:checked)').closest('tr').find('.special_time_picker_open').attr('disabled', true)
        $('.holiday_status:not(:checked)').closest('tr').find('.special_time_picker_close').attr('disabled', true)
    }

    let handleDays = function () {
        let style = $('#style_business').val()
        if (style == 'style_business_3' || style == 'style_business_4' || style == 'style_business_9') {
            $('.display_alldays').hide()
            $('.display_weekday').show()
        } else {
            $('.display_alldays').show()
            $('.display_weekday').hide()
        }
    }

    document.querySelector('.custom_business_hour_plugin').addEventListener('click', function (e) {

        if (e.target.classList.contains('add_special_holiday')) {
            let parent = document.querySelector('.holidays_special_hours')
            parent.appendChild(createHoliday())
            toggleChange()
            setHour()
        }

        if (e.target.classList.contains('rm_special_holiday')) {
            e.target.closest('tr').remove()
            loadPreview()
        }
        let id = document.getElementById('shortcode_id').value
        if (e.target.id == 'shortcode_generate') {
            id = id == '' ? null : id
            let data = BH.get()
            console.log(data)
            data.nonce = nnonce
            data.action = 'get_option_data'
            data.id = id
            jQuery.ajax({
                url: ajaxurl,
                method: 'POST',
                cache: false,
                data,
                success: function (response) {
                    let sep = response.id.split('_')[3]
                    document.getElementById('shortcode_id').value = response.id
                    document.querySelectorAll('.shortcode span')[0].innerHTML = `[stylish_business_hour id="${sep}"]`
                    document.querySelectorAll('.shortcode span')[1].innerHTML = `[stylish_business_hour type ="status" id="${sep}"]`
                },
                error: function (e) {
                    console.log(e)
                }
            })
        }
        if (e.target.classList.contains('bnt_copy')) {
            let $row = e.target.closest('tr')
            let $swich = $row.querySelector('.timing')
            $swich.checked = true
            $swich.closest('td').querySelector('.switch').classList.add('checked')
            $row.querySelector('.status').innerHTML = 'OPEN'
            // insert first, get times, then assign
            $($row).append(createHours())
            e.target.closest('td').remove()

            let $monday = document.querySelectorAll('.display_alldays')[0].closest('tr')
            let $mondayOpen = $monday.querySelector('.timepicker_open')
            let $mondayClose = $monday.querySelector('.timepicker_close')

            $row.querySelector('.timepicker_open').value = $mondayOpen.value
            $row.querySelector('.timepicker_close').value = $mondayClose.value
            setHour()
            loadPreview()
        }

    })

    function toggleChange() {
        $('.timing,.timing2').on('change', function () {
            if ($(this).is(':checked')) {
                $(this).closest('.switch').addClass('checked')
                $(this).closest('td').find('span').text('OPEN')
            } else {
                $(this).closest('.switch').removeClass('checked')
                $(this).closest('td').find('span').text('CLOSE')
            }

        })
    }

    const BH = new BusinesH()
    const nnonce = data.wnonce
    BH.init()

    function loadPreview() {
        let data = BH.get()
        data.action = 'showPreview'
        data.nonce = nnonce
        jQuery.ajax({
            url: ajaxurl,
            method: 'POST',
            cache: false,
            data,
            success: function (data) {
                $(".preview").html(data)
            }
        })
    }

    let tdCopy = function () {
        let td = document.createElement('td')
        td.classList.add('td-btn-copy')
        let btn = document.createElement('button')
        btn.classList.add('btn', 'btn-warning', 'bnt_copy')
        btn.innerHTML = 'Copy from Monday'
        td.appendChild(btn)
        return td
    }

    function copyButton() {
        document.querySelectorAll('.display_alldays').forEach(function (element, i) {
            if (i == 0) return
            if (element.closest('tr').querySelector('.timing').checked) return
            element.appendChild(tdCopy())
        });
    }

    if (!document.getElementById('shortcode_id').value) {
        let parent = document.querySelectorAll('.display_alldays')[0].closest('tr')
        let sss = parent.querySelector('.switch')
        sss.classList.add('checked')
        parent.querySelector('.timing').checked = true
        $(parent).append(createHours())
        setHour()

    }

    function removedBtnsFist() {
        let parent = document.querySelectorAll('.display_alldays')[0].closest('tr')
        let sss = parent.querySelector('.timing')
        sss.addEventListener('change', function (e) {
            if (!this.checked) {
                $('.td-btn-copy').remove()
            } else {
                copyButton()
            }
        })
        if (sss.checked) parent.querySelector('span.status').innerHTML = 'OPEN'
        else $('.td-btn-copy').remove()
    }

    copyButton()
    removedBtnsFist()

})