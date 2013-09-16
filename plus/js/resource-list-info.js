jQuery(document).ready(function($) {
    $('.resource-info-btn').css('cursor','pointer').removeAttr("href").click( function() { fx_hideinfo(this); } )
    $('.resource-info-btn-all').css('cursor','pointer').click( function() { fx_hide_all_info(this); } )

    // fx_add_infolinks();
    $('.collapsed').hide();
});

function fx_hideinfo(resourceinfobtn) {
  resourceinfo = jQuery(resourceinfobtn).parent().siblings('.resource-info');
  if (resourceinfo.is('.collapsed')) {
      jQuery(resourceinfo).removeClass('collapsed').slideDown();
  } else {
      jQuery(resourceinfo).addClass('collapsed').slideUp();
  }
}

function fx_hide_all_info(resourceinfobtn) {
  resourceinfo = jQuery(resourceinfobtn);
  if (resourceinfo.is('.collapsed')) {
      resourceinfo.removeClass('collapsed');
      jQuery('.resource-info').removeClass('collapsed').slideDown();
  } else {
    resourceinfo.addClass('collapsed');
      jQuery('.resource-info').addClass('collapsed').slideUp();
  }
}

// no longer necessary as views only showing icon if body text exists
function fx_add_infolinks() {
  $('.resource-info-btn').each(function() {
    if ($(this).parent().siblings('.resource-info').length > 0) {
      $(this).removeAttr("href").click( function() { fx_hideinfo(this); } )
    } else {
      $(this).html('');
    }
  });
}