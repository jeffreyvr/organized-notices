<?php
/**
 * Plugin name: Organized Notices
 * Description: Moving all notices into a modal, trying to reduce the admin clutter. (POC)
 * Author: Jeffrey van Rossum
 * Version: 0.0.1
 */

add_action('admin_bar_menu', function ($admin_bar) {
    $admin_bar->add_menu(array(
        'id'    => 'organized-notices',
        'title' => '',
        'parent' => 'top-secondary',
        'href'  => '#',
        'meta'  => array(
            'title' => __('Organized notices'),
            'onclick' => 'jQuery("#organized-notices-container").toggleClass("organized-notices-hidden");'
        ),
    ));
}, 100);

add_action('admin_head', function() {
?>
<style>
#organized-notices-container {
    background: rgba(0, 0, 0, .5);
    -webkit-backdrop-filter: blur(8px);
    backdrop-filter: blur(8px);
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}

#organized-notices-container .inside {
    padding: 5px 25px 15px 25px;
    max-width: 960px;
    width: 100%;
    background-color: #fff;
    overflow: auto;
    max-height: 95%;
}

#organized-notices-container .copied-notice {
    margin: 10px 0px;
}

.organized-notices-toggle {
    padding: 0;
    margin: 0;
    border: none;
    background: transparent;
}

.organized-notices-toggle:hover {
    cursor: pointer;
}

#wp-admin-bar-organized-notices a {
    display: inline-flex !important;
    align-items: center;
    gap: 5px;
}

.organized-notices-count {
    background-color: #d63638;
    height: 18px !important;
    border-radius: 9999px !important;
    width: 18px !important;
    text-align: center;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.organized-notices-hidden {
    display: none !important;
}

#message:not(.notice-success, .updated),
.notice:not(.notice-success, .updated) {
    display: none;
}
</style>
<?php
});

add_action('admin_footer', function () {
?>
<div id="organized-notices-container" class="organized-notices-hidden">
    <div class="inside">
        <div style="display: flex; width: 100%; justify-content: space-between; align-items: center;">
            <h2>Notices</h2>
            <button class="organized-notices-toggle" aria-label="Close notices modal" onclick="jQuery('#organized-notices-container').toggleClass('organized-notices-hidden');">
                <span class="dashicons dashicons-no"></span>
            </button>
        </div>
        <div class="notices"></div>
    </div>
</div>
<script>
    jQuery(function($) {

        setTimeout(() => {
            var notices = $('body').find('#wpbody-content .wrap > #message:not(".notice-success, .updated"), #wpbody-content .wrap > .notice:not(".notice-success, .updated")');
            var collection = $('#organized-notices-container .notices');
            var nav_item = $('#wp-admin-bar-organized-notices a');
            var nav_item_text = nav_item.text();

            if(notices.length === 0) {
                nav_item.remove();
            } else {
                nav_item.html('Notices <span class="organized-notices-count">'+notices.length+'</span>');

                notices.each(function(index, notice) {
                    $(notice).addClass('copied-notice');

                    $(notice).css('display', 'block');

                    $(notice).appendTo(collection);
                });
            }
        }, 1);
    });
</script>
<?php
});
