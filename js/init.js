/**
 * Initialize the GDPR features
 */

// Object.keys(Cookies.get()).forEach(function(cookieName) {
//   var neededAttributes = {
//     // Here you pass the same attributes that were used when the cookie was created
//     // and are required when removing the cookie
//   };
//   Cookies.remove(cookieName, neededAttributes);
// });

function logCookies(message) {
    var c = Cookies.get('', { path: '', domain: 'app-abk.marketo.com' });
    console.log(message + ' cookies');
    console.dir(c);
}

gdpr.enablCookies = function() {
    logCookies('enable');
};

gdpr.disableCookies = function() {
    logCookies('disable');
};

window.addEventListener("load", function(){
    // console.log(gdpr)
    window.cookieconsent.initialise(
	{
	    "content": {
		"message" : gdpr.message,
		"dismiss" : gdpr.dismiss,
		"deny" : gdpr.deny,
		"link" : gdpr.link,
		"href" : gdpr.href
	    },
	    "palette" : {
		"popup": {
		    "background":"#464646",
		    "text":"#ddd"
		},
		"button": {
		    "background":"#82bd41"
		}
	    },
	    "type" : "opt-out",
	    onInitialise: function (status) {
		var type = this.options.type;
		var didConsent = this.hasConsented();
		if (type == 'opt-in' && didConsent) {
		    logCookies('enable');
		}
		if (type == 'opt-out' && !didConsent) {
		    logCookies('disable');
		}
	    },
	    onStatusChange: function(status, chosenBefore) {
		var type = this.options.type;
		var didConsent = this.hasConsented();
		if (type == 'opt-in' && didConsent) {
		    logCookies('enable');
		}
		if (type == 'opt-out' && !didConsent) {
		    logCookies('disable');
		}
	    },
	    onRevokeChoice: function() {
		var type = this.options.type;
		if (type == 'opt-in') {
		    logCookies('disable');
		}
		if (type == 'opt-out') {
		    logCookies('enable');
		}
	    }
	});
});
