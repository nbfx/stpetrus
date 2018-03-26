$(document).ready(function () {
    $(function(){
        $.datetimepicker.setLocale('{{ app()->getLocale() }}');
        $('[name=date_time]').datetimepicker({
            format: 'd.m.Y H:i'
        });
    });

    $('.feedback_form').on('submit', function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data){
                $('.feedback-error', $this).remove();
                if (data.errors !== undefined) {
                    console.log($(this)); //TODO
                    $.each(data.errors, function (name, item) {
                        $this.find('[name='+name+']').parent().append('<span class="feedback-error">'+item[0]+'</span>');
                    });

                } else {
                    $this.fadeOut(250, function () {
                        $this.next('.response-message').text(data.message).fadeIn(250);
                    });
                }
            },
            error: function(data){
                $('#response-message').text('Internal error! Try again later!');
            }
        });
    });
});