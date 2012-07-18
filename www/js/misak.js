

(function ($) {

	var Misak = function () {
		var misak = this;

		this.basePath = 'http://localhost/own_webs/misak113.avantcore.cz/www';

		this.start = function () {
			bindWakeOn();
			checkingTurnedOn();
		}

		var bindWakeOn = function () {
			$('.computer_wakeOn').click(function (ev) {
				ev.preventDefault();
				var name = $(this).attr('data-name');
				$.ajax({
					url: misak.basePath+'/wakeOn/'+name,
					dataType: 'json',
					success: function (resp) {
						if (resp.status == 'ok') {
							alert('Počítači byl zaslán požadavek na spuštění: '+resp.message);
						} else {
							alert(resp.message);
						}
					}
				});
			});
		}

		var checkingTurnedOn = function () {

			$('.computer_status').each(function () {
				var el = $(this);
				var checkTurnedOn;
				checkTurnedOn = function (ev) {
					var name = el.attr('data-name');
					$.ajax({
						url: misak.basePath+'/turnedOn/'+name,
						dataType: 'json',
						success: function (resp) {
							var img = $('#computer_status_'+name);
							var src = img.attr('src');
							if (resp.turnedOn) {
								src = src.replace('offline.gif', 'online.gif');
							} else {
								src = src.replace('online.gif', 'offline.gif');
							}
							img.attr('src', src);
							setTimeout(checkTurnedOn, 2000);
						}
					});
				};
				checkTurnedOn();
			});
		}

	}

	$(document).ready(function () {
		var misak = new Misak();
		misak.start();
	});

})(jQuery)