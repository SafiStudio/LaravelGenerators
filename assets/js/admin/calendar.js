var ssCalendar = function(identifier){
    // input field
    var _input = undefined;
    // month names
    var _months = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    // day names
    var _days = ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'];
    // day short names
    var _short_days = ['nd', 'pn', 'wt', 'śr', 'cz', 'pt', 'sb'];
    // value of input field
    var _value = '';

    /**
     * Get string from Date and set it as input value
     *
     * @returns {string}
     */
    var getDateString = function(){
        var dYear = _active_day.getFullYear();
        var dMonth = _active_day.getMonth()+1;
        if(dMonth < 10)
            dMonth = '0' + dMonth;
        var dDay = _active_day.getDate();
        if(dDay < 10)
            dDay = '0' + dDay;

        _value = dYear + '-' + dMonth + '-' + dDay;
        $(_input).val(_value);
        return _value;
    }

    /**
     * Hide active calendar
     */
    var hideCalendar= function(){
        if($('#ssCalendar') != undefined){
            $('#ssCalendar').removeClass('loaded');
            setTimeout(function(){
                $('#ssCalendar').remove();
            }, 500);
        }
    }

    /**
     * Get HTML of days grid
     *
     * @returns {string}
     */
    var getCalendarGrid = function(){
        var fday = new Date(_active_day.getFullYear(), _active_day.getMonth(), 1).getDay();
        var days =  new Date(_active_day.getFullYear(), _active_day.getMonth(), 0).getDate();
        var gridHTML = '';
        for (var i=0; i<=6; i++){
            gridHTML += '<span class="short-day">'+_short_days[i]+'</span>';
        }
        for (var i=0; i<days+fday; i++){
            var active = '';
            if(i>=fday){
                if((i-fday+1)==_today.getDate() && _today.getFullYear()==_active_day.getFullYear() && _today.getMonth()==_active_day.getMonth())
                    active = ' active';
                gridHTML += '<span class="active-day'+active+'">'+(i-fday+1)+'</span>';
            }
            else{
                gridHTML += '<span class="empty-day">&nbsp;</span>';
            }
        }
        return gridHTML;
    }

    /**
     * Set actions for day spans and navigation
     */
    var setActions = function(mnav){
        $('#ssCalendar span.active-day').click(function(){
            _active_day.setDate($(this).text());
            getDateString();
            hideCalendar();
        });
        $('#ssCalendar .overlay').click(function(){
            hideCalendar();
        });
        if(mnav!=undefined && mnav==true){
            $('#ssCalendar #prevMonth').click(function(){
                prevMonth();
            });
            $('#ssCalendar #nextMonth').click(function(){
                nextMonth();
            });
        }
    }

    /**
     * Navigate to next month
     */
    var nextMonth = function(){
        if(_active_day.getMonth() < 12){
            _active_day.setMonth(_active_day.getMonth()+1);
            _active_day.setDate(1);
        }
        else{
            _active_day.setFullYear(_active_day.getFullYear()+1);
            _active_day.setMonth(1);
            _active_day.setDate(1);
        }
        var monthHTML = _months[_active_day.getMonth()]+' '+_active_day.getFullYear();
        $('#ssCalendar .card-head h4').html(monthHTML);
        var calendarGrid = getCalendarGrid();
        $('#ssCalendar .card-grid').html(calendarGrid);
        setActions(false);
    }

    /**
     * Navigate to previous month
     */
    var prevMonth = function(){
        if(_active_day.getMonth() > 1){
            _active_day.setMonth(_active_day.getMonth()-1);
            _active_day.setDate(1);
        }
        else{
            _active_day.setFullYear(_active_day.getFullYear()-1);
            _active_day.setMonth(11);
            _active_day.setDate(1);
        }
        var monthHTML = _months[_active_day.getMonth()]+' '+_active_day.getFullYear();
        $('#ssCalendar .card-head h4').html(monthHTML);
        var calendarGrid = getCalendarGrid();
        $('#ssCalendar .card-grid').html(calendarGrid);
        setActions(false);
    }

    /**
     * Show calendar
     */
    var showCalendar = function(){
        if($('#ssCalendar') != undefined){
            $('#ssCalendar').remove();
        }
        $('body').append('<div id="ssCalendar"></div>');
        var calendarHead = '<div class="card-head"><span id="prevMonth"><i class="fa fa-angle-left"></i></span><h4>'+_months[_today.getMonth()]+' '+_today.getFullYear()+'</h4><span id="nextMonth"><i class="fa fa-angle-right"></i></span></div>';
        var calendarDate = '<div class="card-date"><h2>'+_today.getDate()+'</h2><h3>'+_days[_today.getDay()]+'</h3></div>';
        var calendarGrid = getCalendarGrid();
        var calendar = $('#ssCalendar');
        $(calendar).html('<div class="overlay"></div><div id="calendar-card" class="card calendar">'+calendarHead+calendarDate+'<div class="card-grid">'+calendarGrid+'</div></div>');
        setTimeout(function(){
            $('#ssCalendar').addClass('loaded');
        }, 100);
        setActions(true);
    }

    // selected day
    var _today = new Date();
    // active day, month, year
    var _active_day = new Date();

    /**
     * Initiate calendar for input selector
     *
     * @returns {boolean}
     */
    var initiate = function(){
        if(_input == undefined){
            console.log('Can not find input element');
            return false;
        }
        if($(_input).val()!=''){
            _value = $(_input).val().split('-');
            if(_value.length==3 && _value[0].length==4 && _value[1].length==2 && _value[2].length==2 && _value[1]<=12){
                _value = $(_input).val();
            }
            else{
                _value = '';
            }
        }
        if(_value != ''){
            _today = new Date(_value+'T00:00:00');
            _active_day = new Date(_value+'T00:00:00');
        }
        else{
            _value = getDateString();
        }
        showCalendar();
    }

    /**
     * Initiate calendar for all inputs having identifier
     */
    $.each($('input'+identifier), function(item, ie){
       $(ie).click(function(){
           _input = $(ie);
           initiate();
       });
    });
}