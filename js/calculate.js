
$(document).ready(function()
{
    $('#'+$('[data-selector="Likelihood"]').attr('id')).change(function(){
        calc();
    })


    $('#'+$('[data-selector="Confidentiality"]').attr('id')).change(function(){
        calc();
    })

    $('#'+$('[data-selector="Integrity"]').attr('id')).change(function(){
        calc();
    })

    $('#'+$('[data-selector="Avilability"]').attr('id')).change(function(){
        calc();
    })

    function calc(value, classification)
    {

        var val1 = parseInt($('#'+$('[data-selector="Likelihood"]').attr('id')).val());
        var val2 = parseInt($('#'+$('[data-selector="Confidentiality"]').attr('id')).val());
        var val3 = parseInt($('#'+$('[data-selector="Integrity"]').attr('id')).val());
        var val4 = parseInt($('#'+$('[data-selector="Avilability"]').attr('id')).val());

        if(val1 == -1)
        {
            val1 = 0;
        }

        if(val2 == -1)
        {
            val2 = 0;
        }

        if(val3 == -1)
        {
            val3 = 0;
        }

        if(val4 == -1)
        {
            val4 = 0;
        }

        var score = val1 + val2 + val3 + val4;

        $('#risk_score_total').val(score);
    }

})