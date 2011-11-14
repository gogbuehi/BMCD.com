/**
 * @author Goodwin Ogbuehi
 * September 20, 2008
 */

function form_onsubmit() {
	alert('form submitted');
	var io = document.getElementById("results");
	var io2 = document.getElementById("results2");
	/*
	$.ajaxFileUpload
		(
			{
				url:UPLOAD_URL,
				secureuri:false,
				fileElementId:'Filedata',
				dataType: 'json',
				success: function (data, status)
				{
					if(typeof(data.error) != 'undefined')
					{
						if(data.error != '')
						{
							alert(data.error);
						}else
						{
							alert(data.msg);
						}
					}
				},
				error: function (data, status, e)
				{
					alert(e);
				}
			}
		)
	return false;
	*/
}

function assignEvents() {
	$("form").submit(form_onsubmit)
}
