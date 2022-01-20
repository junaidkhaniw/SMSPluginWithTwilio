<?php

namespace Inc;

class Activate
{
    public static function activate() {
        if (!get_option('jk_scroll_to_top_color')) {
			update_option('jk_scroll_to_top_color', 'black');
		}
		if (!get_option('jk_scroll_to_top_speed')) {
			update_option('jk_scroll_to_top_speed', 'slow');
		}
        flush_rewrite_rules();
    }
}