/**
 * Initialize the GDPR features
 */
window.addEventListener("load", function(){
	console.log(gdprCcContent)
    window.cookieconsent.initialise(
	{
	    "content": {
				"message": gdprCcContent.message,
				"dismiss": gdprCcContent.dismiss,
				"link": gdprCcContent.link,
				"href": gdprCcContent.href,
			},
	    "palette" : {
			"popup": {
				"background":"#464646",
				"text":"#ddd"
			},
			"button": {
				"background":"#82bd41"
			}
	    }
	});
});
