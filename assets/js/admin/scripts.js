$(document).ready(function(){

    // FORMS START -------------
    $.each($('.safi-checkbox'), function(item, element){
        var checkbox = $(element).find('input').first();
        if(checkbox.is(':checked'))
            $(element).addClass('active');
        else
            $(element).removeClass('active');
    });

    $('.safi-checkbox').click(function(){
        var input = $(this).find('input').first();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $(input).prop('checked',false);
        }
        else{
            $(this).addClass('active');
            $(input).prop('checked',true);
        }
    });

    $('.form-line-file').change(function(){
        var ctr = $(this).parent().find('em').first();
        $(ctr).text($(this).val());
    });

    $('#saveForm').click(function(){
        $('#adminForm').submit();
    });

    $('.actions .remove').click(function(){
        return confirm('Czy jesteś pewny, że chcesz wykonać akcję ?');
    });

    ssCalendar('.calendar');
    // FORMS END ---------------

    // ALERTS
    $('.alert').click(function(){
        $(this).fadeOut();
    });
    // END ALERTS

    // SEARCH
    $('.search-box .button.search').click(function(){
        if($(this).parent().hasClass('active'))
            $(this).parent().removeClass('active');
        else
            $(this).parent().addClass('active');
    });
    $('.search-box .search-input-value').keyup(function(){
       $('.search-box .search-value').text($(this).val());
    });
    $('.search-box .search-input-value').change(function(){
       $('.search-box .search-value').text($(this).val());
    });
    // END SEARCH

});
