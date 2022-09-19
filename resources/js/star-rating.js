require('raty-js');

$.raty.path = '/images';
// $('#star').empty();
// $('#star').raty({

// });


$('#star-rating').empty();
$('#star-rating').raty({
  readOnly: true,
  score: function () {
    return $(this).attr('data-score');
  }
});


$('#star-avg-rating').empty();
$('#star-avg-rating').raty({
  readOnly: true,
  score: function () {
    return $(this).attr('data-score');
  }
});


$('#star-post').empty();
$('#star-post').raty({
  half: true,
});

$('#star-edit-post').empty();
$('#star-edit-post').raty({
  half: true,
  score: function () {
    return $(this).attr('data-score');
  }
});
