<?php

namespace Inc;

class Deactivate
{
    public static function deactivate() {
        delete_option('jk_scroll_to_top_color');
		delete_option('jk_scroll_to_top_speed');
        flush_rewrite_rules();
    }
}