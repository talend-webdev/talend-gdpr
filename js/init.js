/**
 * Initialize the GDPR features
 */


function logCookies(message) {
    // var c = Cookies.get('cookieconsent_status', { path: '', domain: 'talend.com' });
    // console.log(message + ' cookies');
    // console.dir(c);
}

function enableCookies() {
    // nothing to do, cookies enabled by default
}

function disableCookies() {
    // logCookies('disable');
    var consent = Cookies.get('cookieconsent_status', { path: '', domain: 'talend.com' });

    if(consent === 'deny') {
	Object.keys(Cookies.get()).forEach(function(cookieName) {
	    if(cookieName !== 'cookieconsent_status') {
		Cookies.remove(cookieName);
	    }
	});
    }
};

window.addEventListener("load", function(){
    window.cookieconsent.initialise(
	{
	    "content": {
		"message" : gdpr.message,
		"privacy" : gdpr.privacy,
		"allow" : gdpr.dismiss,
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
	    onPopupOpen: function() {
		const message = document.getElementById('cookieconsent:desc');
		if (message.querySelector('p') != null) {
		    return;
		}
		let privacy = document.createElement('p');
		privacy.innerHTML = '<strong>' + window.gdpr.privacy + '</strong>';
		privacy.style.color = 'red';
		message.appendChild(privacy);
	    },
	    onInitialise: function (status) {
		const type = this.options.type;
		const didConsent = this.hasConsented();
		if (type == 'opt-in' && didConsent) {
		    enableCookies();
		}
		if (type == 'opt-out' && !didConsent) {
		    disableCookies();
		}
	    },
	    onStatusChange: function(status, chosenBefore) {
		var type = this.options.type;
		var didConsent = this.hasConsented();
		if (type == 'opt-in' && didConsent) {
		    enableCookies();
		}
		if (type == 'opt-out' && !didConsent) {
		    disableCookies();
		}
	    },
	    onRevokeChoice: function() {
		var type = this.options.type;
		if (type == 'opt-in') {
		    disableCookies();
		}
		if (type == 'opt-out') {
		    enableCookies();
		}
	    }
	});

});
