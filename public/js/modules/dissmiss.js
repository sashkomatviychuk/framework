// $.event.trigger({type: 'dissmiss'});

$('.js-dissmiss').on('click', function (e) {
	e.preventDefault();
	$(this).trigger('dissmiss');
});

$('.js-dissmiss-user-data').on('dissmiss', function (e) {
	var $select = $('.js-select-user');

	$select.text($select.data('dissmiss-text'));
	$('[name=member_id]').val('');
});
