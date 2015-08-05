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
    // FORMS END ---------------

    $('.alert').click(function(){
        $(this).fadeOut();
    });

});
