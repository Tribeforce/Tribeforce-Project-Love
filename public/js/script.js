$(document).ready(function() {
  // Set a minimum height
  // TODO: avoid scrollbars
  $('body').css('minHeight', $(window).height());

  // Attach the datepickers
  var today = new Date();
  $('input#birth_date').pickadate({
    max: new Date(today.getFullYear()-18, today.getMonth(), today.getDate()),
    min: new Date(1900,1,1),
    selectYears: 100,
    format:"dddd d mmmm yyyy",
    formatSubmit:"yyyy/mm/dd"
  });
  $('input#hire_date').pickadate({
    max: new Date(today.getFullYear()+1, today.getMonth(), today.getDate()),
    min: new Date(today.getFullYear()-50, today.getMonth(), today.getDate()),
    selectYears: 100,
    format:"dddd d mmmm yyyy",
    formatSubmit:"yyyy/mm/dd"
  });


  /**** COLLAPSIBLE FIELDSETS ****/
  // Attach click handler: Make fieldsets collapsible
  $('fieldset legend').click(function(){
    $(this).parent().toggleClass('collapsed');
    $(this).siblings().slideToggle();
  });

  // Slide the collapsed fieldset up on page load
  $('.collapsed legend').each(function() {
    $(this).siblings().slideToggle();
  });

  /**** TOPMENU ANIMATION ****/
  // Attach click handler
  $('nav.top-bar .toggle-topbar').click(function() {
    $selector = $('nav.top-bar section.top-bar-section');
    if($('nav.top-bar').hasClass('expanded')) {
      if($(window).width() < 768) {
        $selector.slideUp();
      }
    } else {
      $selector.slideDown();
    }
  });

  // The resize actions
  $(window).resize(function() {
    $selector = $('nav.top-bar section.top-bar-section');
    if($(window).width() > 520) {
      $selector.slideDown();
    } else {
      $selector.slideUp();
    }
  });

  // On load, we always slide up except if we are in wide screen
  if($(window).width() <= 520) {
    $('nav.top-bar section.top-bar-section').slideUp();
  }



/*** CONFIGURATIONS ***/
  var drag_conf = {
    revert: 'invalid',
    helper: 'clone'
  };

  var drop_conf = {
    accept: function(draggable) {
      var id = draggable.attr('id');
      if($(this).find('[id=' + id + ']').length > 0) {
        return false; // If the user already exists in the circle
      } else if(id.substring(0,5) === 'user-') {
        return true;  // If the id of the draggable starts with 'user-'
      } else {
        return false; // All other cases should not be accepted
      }
    },
    activeClass: "dragging",
    hoverClass: "hovering",
    drop: function(event, ui) {
      var circleId = $(this).attr('id').substring(7);
      var url = '/circles/' + circleId;
      var userId = ui.draggable.attr('id').substring(5);
      var csrf_token = $('#circles-index > [name=_token]').val();

      $.ajax(url, {
        data: { add: userId, _token: csrf_token },
        type: 'PUT'
      });
    }
  };

  var ac_conf = {
    minLength: 3,
    source: '/friends/autocomplete',
    html: true,
    select: function( event, ui ) {
      $('#friends-add #autocomplete').softHide();
      $('#friends-add form [name=friend]').val(ui.item.id);
      $('#friends-add form').softShow();
      $('#friends-add #result .result').html(ui.item.label);
      $('#friends-add #result').softShow();
      $('#friends-add .delete').click(function() {
        $('#friends-add form').softHide();
        $('#friends-add #result .result').html('');
        $('#friends-add #autocomplete').softShow();
        $('#friends-add #autocomplete input').val('').focus();
      });

    }
  };


  $('#circles-index [id^=user-]').draggable(drag_conf);
  $('#circles-own [id^=circle-]').droppable(drop_conf);








  $.ajaxSetup({
    dataType: 'json',
    statusCode: {  // TODO: Show disappearing message for errors
      404: function() {
        alert("page not found");
      }
    },
    success: function(data, status, jqXHR ) {
      var timer = 0;

      for(i = 0; i < data.length; i++) {
        // Set the timer
        timer = 0;
        if(data[i].timer !== undefined) {
          timer = data[i].timer;
        }

        // Set the selector
        selector = data[i].selector;

        switch(data[i].method) {
          case 'append':
            $(selector).append(data[i].html);
            $(selector + ' div.ajax').slideDown();
            break;
          case 'replace':
            $h = data[i].html;
            $(selector).fadeOut(function(){
              $(this).replaceWith($h).hide().fadeIn();
            });
            break;
          case 'html':
            $h = data[i].html;
            $(selector).fadeOut(function(){
              $(this).html($h).hide().fadeIn();
            });
            break;
          case 'after':
            $(selector).after(data[i].html);
            $(selector + ' div.ajax').slideDown();
            break;
          case 'before':
            $(selector).before(data[i].html);
            $(selector).prev('div.ajax').hide().slideDown();
            break;
          case 'hide':
            setTimeout(function(s) { s.slideUp(); }, timer, $(selector));
            break;
          case 'show':
            $(selector).softShow();
            break;
          case 'remove':
            setTimeout(function(s) { s.softRemove(); }, timer, $(selector));
            break;
          case 'addClass':
            $(selector).addClass(data[i].classes);
            break;
          case 'removeClass':
            $(selector).removeClass(data[i].classes);
            break;
          case 'flush':
            $(selector).find('textarea').val('');
            $(selector).find('input:not([type=submit])').val('');
            break;
          case 'focus':
            $(selector).focus();
            break;
          case 'click':
            $(selector).click();
            break;
          case 'overlay':
            $h = data[i].html;
            $('body').append($h);
            $('.ajax').show();             // Unhide the AJAX if needed
            $('.reveal-modal').foundation('reveal', 'open');
            break;
          case 'removeOverlay':
            $('.reveal-modal').foundation('reveal', 'close');
            break;
          case 'makeDroppable':
            $(selector).droppable(drop_conf);
            break;
          case 'makeAutocomplete':
            $(selector).autocomplete(ac_conf);
            break;
          case 'slide':
            $h = data[i].html;
            $(selector).wrap('<div id="slider-outer" />')
                       .wrap('<div id="slider-inner" />');
            var w = $(selector).width();
            $('#slider-outer').width(w);
            $('#slider-inner').width(2*w);
            if(data[i].direction === 'left') {
              $('#slider-inner ' + selector).before($h);
              $('#slider-inner > li').width(w);
              $('#slider-inner > li').first().css('marginLeft', -1*w);
              $('#slider-inner > li').first().animate({marginLeft: ''},
                function() {
                  $('#slider-inner > li').last().remove();
                  $(this).unwrap().unwrap().css({marginLeft: '', width: ''});
                }
              );
            } else if(data[i].direction === 'right') {
              $('#slider-inner ' + selector).after($h);
              $('#slider-inner > li').width(w);
              $('#slider-inner > li').first().animate({marginLeft: -1*w},
                function() {
                  $next = $(this).next();
                  $(this).remove();
                  $next.unwrap().unwrap().css({marginLeft: '', width: ''});
                }
              );
            }

            break;
        }
      }
    }
  });

  // Make sure all AJAX links are handled using AJAX
  $('body').delegate('a.ajax', 'click', function(event) {
    event.preventDefault();
    var url = $(this).attr('href');
    var method = $(this).data('method') || 'GET';
    // A cancel has to remove what has been added by AJAX
    if($(this).hasClass('cancel')) {
      $(this).parents('.ajax').next().softShow();  // If method was before
      $(this).parents('.ajax').prev().softShow();  // If method was after
      $(this).parents('.ajax').softRemove();
      $(this).parents('li').find('.actions').softShow();
    } else { // Normal case
      $.ajax(url, {type: method});
    }
  });

  // Helper functions
  $.fn.softRemove = function() {
    $(this).slideUp(function() {
      $(this).remove();
    });
  };

  $.fn.softHide = function() {
    $(this).slideUp();
  };

  $.fn.softShow = function() {
    $(this).slideDown();
//    $(this).css('display', ''); // Unset the display so it takes the CSS rules
  };

  // Make forms entered through AJAX also submit through AJAX
  $('body')
    .delegate('.ajax input[type=submit]', 'click', function(event){
      event.preventDefault();
      $form = $(this).parents('form');
      url = $form.attr('action');
      data = $form.serialize();
      $.post(url, data);
    });

  // Simulate submit buttons and make sure the buttons added through AJAX
  // also have the simulate functionality
  $('body').delegate('[class*=icon-]', 'click', function(event){
    $(this).next('input[type=submit]').click();
  });


  // Handle key presses for filter fields added through AJAX
  $('body').delegate('input[name=filter]', 'keyup', function(event){
    var searchText = $(this).val().toLowerCase();

    // Search in the content of the objects
    $('[id^=user-], [id^=circle-]').each(function(f, d, g) {
      text = $(this).text().trim().toLowerCase();
      if(text.indexOf(searchText) === -1) {  // -1 is not found
        $(this).softHide();
      } else {
        $(this).softShow();
      }
    });
  });
});

/**** GLOBAL FUNCTIONS ****/
accordeonSlide = function(options) {
//  $('.section-container .content').slideUp();
  $('.section-container .active .content').css('display', 'none').slideDown();
};

revealClosed = function() {
  setTimeout(function() {
    $('.reveal-modal.remove-on-close').remove();
    $('body > .ajax').remove();
    $('.reveal-modal-bg').remove();
  }, 500);
};
