/******************************
 *
 * pstats - Palm webOS app stats
 * v0.1.0
 * January 4, 2011
 *
 * http://www.jdf-software.com/pstats
 *
 * usage:
 *
 * var stats = new pstats(this);
 * stats.send();
 *
 * where "this" is actually just the word "this"
 *
 ******************************/

function pstats(parent) {

	this.cont = parent.controller;

	this.data = {};

	// since last check cookie
	this.cookie = new Mojo.Model.Cookie("_pstats");

	this.cookieData = this.cookie.get();


	/* methods ***************************************/
	this.send = function() {

		// see if there's a cookie that has the data stored in it and send from that
		if (this.cookieData) {

			this.data = this.cookieData;

			this.sendData();

		}

		// if there's no cookie, retrieve the data first
		else {

			this.retrieveData(); // this will eventually call the this.sendData() function

		}

	}


	this.retrieveData = function() {

		/* data from appinfo.js */
		this.data.appid = Mojo.appInfo.id;
		this.data.appVersion = Mojo.appInfo.version;

		/* data from Mojo.Environment */
		this.data.webkitVersion = Mojo.Environment.version;
		this.data.osBuild = Mojo.Environment.build;

		/* data from Mojo.Environment.DeviceInfo */
		this.data.modelName = Mojo.Environment.DeviceInfo.modelName;
		this.data.modelNameAscii = Mojo.Environment.DeviceInfo.modelNameAscii;
		this.data.osVersion = {};
		this.data.osVersion.name = Mojo.Environment.DeviceInfo.platformVersion;
		this.data.osVersion.major = Mojo.Environment.DeviceInfo.platformVersionMajor;
		this.data.osVersion.minor = Mojo.Environment.DeviceInfo.platformVersionMinor;
		this.data.osVersion.dot = Mojo.Environment.DeviceInfo.platformVersionDot;
		this.data.carrier = Mojo.Environment.DeviceInfo.carrierName;
		
		this.data.devWidth = Mojo.Environment.DeviceInfo.screenWidth;
		this.data.devHeight = Mojo.Environment.DeviceInfo.screenHeight;

		/* data from Mojo.Locale */
		this.data.locale = Mojo.Locale.getCurrentLocale();

		// get device uuid
		this.cont.serviceRequest('palm://com.palm.preferences/systemProperties', {
			method:"Get",
			parameters:{"key": "com.palm.properties.nduid" },
			onSuccess: function(response) {

				this.data.uuid = response["com.palm.properties.nduid"];

				// now we have all data, store it in the cookie
				var expire = new Date();
				expire.setTime(expire.getTime()+604800000); // a week from now refresh the data
				this.cookie.put(this.data, expire);

				// send data to server
				this.sendData();
			}.bind(this)
		});

	};

	this.sendData = function() {

		// do AJAX request
		var ajxRequest = new Ajax.Request("http://appaccess.jdf-software.com/pstats/save.php", {
			method: 'post',
			evalJSON: false,
			parameters: {
				"appid": this.data.appid,
				"appver": this.data.appVersion,
				"webkitver": this.data.webkitVersion,
				"osbld": this.data.osBuild,
				"model": this.data.modelName,
				"modelascii": this.data.modelNameAscii,
				"osver": this.data.osVersion.name,
				"osvermj": this.data.osVersion.major,
				"osvermn": this.data.osVersion.minor,
				"osverdt": this.data.osVersion.dot,
				"carrier": this.data.carrier,
				"width": this.data.devWidth,
				"height": this.data.devHeight,
				"locale": this.data.locale,
				"uuid": this.data.uuid
			},
			onSuccess: function(){}
		});

	};
}
