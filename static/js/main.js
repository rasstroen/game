var resources = {'clay':1,'crop':2,'wood':3,'iron':4}

var game = {
	lastCalculateTime: 0,
	socialProfile : {},
	/** main screen **/
	start: function () {

		VK.api('users.get',{fields: 'photo_50'},function(data) {
			if (data.response) {
				this.socialProfile = data.response[0];
				$('.user').show().css('background-image',  'url(' + this.socialProfile.photo_50 + ')');
			}
		});

		this.refreshDataFromServer();
		this.timer();
	},
	init: function (mode) {
		switch (mode) {
			case 'main':
				this.initMain();
				break;
		}
	},
	refreshDataFromServer: function () {
		this.api('refresh', {}, this.onRefreshCallback)
	},
	onRefreshCallback: function (data) {
		for (var i in data.production) {
			$('.production .' + i + ' span').text(Math.round(data.production[i].toString()))
			$('.production .' + i + ' .value').val(data.production[i].toString())
		}
		for (var i in data.productionEnergy) {
			$('.production .' + i + ' .energy').val(data.productionEnergy[i].toString())
		}
	},
	api: function (method, params, callBack) {
		params.method = method;
		$.get('/method/' + method, params, callBack, 'json');
	},
	timer: function () {
		setInterval(this.recalculateProduction, 1000);
	},
	recalculateProduction: function () {
		var _now = new Date();
		var period = 0;
		_now = _now.getTime();
		if(this.lastCalculateTime) {
			period = _now - this.lastCalculateTime;
		}
		else
		{
			this.lastCalculateTime = _now;
		}
		if(period)
		{
			//console.log(period)
			for(var i in resources) {
				var current = $('.production .' + i + ' .value').val();
				var energy = $('.production .' + i + ' .energy').val();
				var add = energy * period / 1000 / 60 / 60;
				var newValue = current - 0 + add - 0;
				//console.log(current + '+' + add + '=' + newValue + ', e=' + energy);
				$('.production .' + i + ' .value').val(newValue);
				$('.production .' + i + ' span').text(Math.round(newValue));
			}
		}
		this.lastCalculateTime = _now;
	}

}
