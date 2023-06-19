jQuery(document).ready(function($) {
  // Gestisci il click sul tasto di blocco
  $('.blocco-notizia').on('click', function() {
    var postId = $(this).data('post-id');
    var bloccato = $(this).data('bloccato');
	
    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'blocco_notizia',
        postId: postId,
        bloccato: !bloccato // Inverti il valore del bloccato
      },
      success: function(response) {
        if (response === 'success') {
          location.reload();
        }
      }
    });
  });

  // Gestisci il click sul tasto di sblocco
  $('.sblocca-notizia').on('click', function() {
    var postId = $(this).data('post-id');

    $.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'sblocca_notizia',
        postId: postId
      },
      success: function(response) {
        if (response === 'success') {
          location.reload();
        }
      }
    });
  });
});
