/**
 * Initialize the GDPR features
 */
window.addEventListener("load", function(){
    window.cookieconsent.initialise(
	{
	    "content": gdprCcContent,
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
