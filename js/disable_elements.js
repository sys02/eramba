$(document).ready(function()
{
	$('#applicable').change(function(){
    	$('#asset_classification_criteria_new').attr('disabled','disabled');
    	$('#risk_classification_criteria_new').attr('disabled','disabled');
	})

	$('#'+$('[data-selector="Likelihood"]').attr('id')).change(function(){
        alert('e');
    })
})