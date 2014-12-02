var App = {
	_data: {},
	_core: {},
	$body: $('body'),

	request: function (data) {
		$.ajax($.extend(data, {
			type: 'POST',
			dataType: 'json'
		}));
	},

	init: function () {
		// alert('Hello!');
	},

	initCreateSecret: function() {
		$('#create').on('click', function() {
			var secret = $('#secret').val();
			var n = $('#count_all').val();
			var k = $('#count').val();

			var input = '';

			$('#res').val('');
			App.request({
				data: {
					'secret': secret,
					'n': n,
					'k': k
				},
				url: '/index/create',
				success: function(data) {
					var input = '';

					$('#secret').val('');

					data['success'] && alert('Долі секрету згенеровано!');
					data['success'] || alert('Долі секрету не згенеровано!');

					$.each(data, function(key, val) {
						App._data[key] = val;
					})

					$.each(data['s'], function(key, val) {
						input += '<li>User '+(key+1)+': '+val+'</li>';
					});
					$('#keys').html(input).show();

					for (var i=0; i<data['k']; ++i) {
						input += '<input type="text" class="u" data-id="'+i+'"><br>';
					}

					$('#users').html(input);
				}
			});
		});
	},

	initRestore: function() {
		$('#restore').on('click', function (e) {

			var sx = 0;
			var d = 1;
			var n = new Array();
			var k = App._data['k'];
			var p = App._data['p'];
			var key = App._data['s'];
			var tmp_keys = new Array;

			$.each($('.u'), function (kk, v) {
				i = $(v).val();
				if (!i) return false;
				n[kk] = i;
				tmp_keys[kk] = App._data['s'][i-1];
			});

			key = tmp_keys;

			for (var i = 0; i < k; ++i) {
				d = 1;

                for (var j = 0; j < k; j++) {
                    if (i != j)
                    {
                        d *= (-1) * (n[j] / (n[i] - n[j]));
                    }
                }

                d = (d*key[i]) % p;
                sx += d;
			}
        	sx = sx % p;

        	sx = Math.floor(sx);

			$('#res').html(sx);
		});
	},

	initMessages: function() {

		var $container = $('.msg');

		$.each( $container, function (k, v) {
			var $c = $(v).html();
			var name = $(v).attr('data-name');

			if ($c.length) {
				$('form').find('[name='+ name +']').addClass('err-field');
				$(v).slideDown(500);
			}
		});

		$('.err-field').first().focus();

		$container.on('click', '.close-msg', function() {
			$(this).parent('.msg').fadeOut(300);
		});
	},

	initDeleteLink: function() {
		App.$body.on('click', 'a.js-remove-url', function (e) {
			e.preventDefault();
			var confirmText = $(this).data('confirm') || 'Delete?';
			var href = $(this).attr('href');
			if (confirm(confirmText)) {
				location.href = href;
			}
		})
	},

	initShowMessage: function () {
		$('div.js-alert-message').removeClass('hide').slideDown(200);

		App.$body.on('click', '.message-close', function (e) {
			e.preventDefault();
			$('.message').slideUp(200);
		})
	},

	construct: function(obj) {
		$.each(App, function (key, val) {
			/^init(.*)?/.test(key) && typeof val == 'function' && val();
		});
	}
};

$(function() {
	App.construct(App);

});
