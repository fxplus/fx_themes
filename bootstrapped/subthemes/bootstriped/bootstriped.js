jQuery(document).ready(function($) {
    $('section.block.collapsible .block-title').css('cursor','pointer').click( function() { fx_hideblock(this); } )
    $('section.block.collapsible.collapsed .block-content').addClass('collapsed').hide();
});

function fx_hideblock(block_title) {
    blockcontent = jQuery(block_title).siblings('.block-content');
    if (blockcontent.is('.collapsed')) {
        jQuery(blockcontent).removeClass('collapsed').slideDown();
    } else {
        jQuery(blockcontent).addClass('collapsed').slideUp();
    }
}