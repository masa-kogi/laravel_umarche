require('raty-js');

$.raty.path = '/images';
// $('#star').empty();
// $('#star').raty({

// });

$('.star-score').each(function () {
  $(this).empty();
  $(this).raty({
    readOnly: true,
    precision: true,
    round: { down: .4, full: .6 },
    score: function () {
      return $(this).attr('data-score');
    }
  });
});


$('#star-avg-score').empty();
$('#star-avg-score').raty({
  readOnly: true,
  score: function () {
    return $(this).attr('data-score');
  }
});

$('.star-avg-score-index').each(function () {
  $(this).empty();
  $(this).raty({
    readOnly: true,
    score: function () {
      return $(this).attr('data-score');
    }
  });
});


$('#star-score-post').empty();
$('#star-score-post').raty({
  half: true,
  target: '#hint',
  targetKeep: true,
  targetType: 'score',
  precision: true,
  round: { down: .4, full: .6 },
});

$('#star-score-edit').empty();
$('#star-score-edit').raty({
  half: true,
  score: function () {
    return $(this).attr('data-score');
  },
  target: '#hint',
  targetKeep: true,
  targetType: 'score',
  precision: true,
  round: { down: .4, full: .6 },
});
