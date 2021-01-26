(function ($) {
    let $allPanels = $('.nested').hide();
    let $elements = $('.treeview-animated-element');
  
    $('.closed').click(function () {
     
      $this = $(this);
      $target = $this.siblings('.nested');
      $pointer = $this.children('.fa-angle-right');
  
      $this.toggleClass('open')
      $pointer.toggleClass('down');
  
      !$target.hasClass('active') ? $target.addClass('active').slideDown() : 
       $target.removeClass('active').slideUp();
  
      return false;
    });
  
    $elements.click(function () {
     
      $this = $(this);
  
     
      $this.hasClass('opened') ? ($this.removeClass('opened')): ($elements.removeClass('opened'), $this.addClass('opened'));
      })
  })(jQuery);