(function($){
    $("#wpfc-submit").click( function( e ){
        e.preventDefault();

        var form                    = {
            action:                 'wpfc_save_settings',
            wpfc_show_details:      $(".wpfc-show-details:checked").val(),
            wpfc_columns:           $("#wpfc-display-columns").val(),
            wpfc_icons:             $("#wpfc-show-icons").val(),
            wpfc_title_font:        $("#wpfc-title-font").val(),
            wpfc_content_font:      $("#wpfc-content-font").val(),
            wpfc_background_color:  $("#wpfc-background-color").val(),
            wpfc_border_color:      $("#wpfc-border-color").val(),
            wpfc_title_color:       $("#wpfc-title-color").val(),
            wpfc_content_color:     $("#wpfc-content-color").val(),
            wpfc_icon_color:        $("#wpfc-icon-color").val(),
        };

        $.post( wpfc_obj.ajax_url, form, function(data){
            alert( data.message );
        });
    } );
})(jQuery)