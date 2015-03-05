<?php

function _action_theme_include_custom_option_types() {
    if (is_admin()) {
        require_once dirname(__FILE__) . '/et-icon/class-fw-option-type-et-icon.php';
    }
}
add_action('fw_init', '_action_theme_include_custom_option_types', 9);

?>