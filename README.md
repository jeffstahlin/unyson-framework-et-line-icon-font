# Add the Elegant Themes Line Icon Font as an Option Type for the Unyson Framework
Elegant Themes Line Icon font as an Option Type

*This is a copy of the icon option type provided with the Unyson Framework, modified to use the Elegant Themes Line Font*

You will be able to use type => 'et-icon' in your options

**Example:**
```php
'et_icon'    => array(
		'type'  => 'et-icon',
		'label' => __('Choose an ET Line Icon', 'fw'),
	),
```

I have included the *includes* folder in a folder named *inc* in the root of my themes folder. You can place the folder wherever you like, just make sure that all paths are updated to point to the right files. Following are all the code and paths that need editing if you have a different folder structure.

### Important: Add this to your functions.php

```php
// Register the new option-type for the Unyson Framework
function _action_theme_include_custom_option_types() {
    if (is_admin()) {
        require_once dirname(__FILE__) . '/inc/includes/option-types/et-icon/class-fw-option-type-et-icon.php';
    }
}
add_action('fw_init', '_action_theme_include_custom_option_types', 9);
```

*Edit the path to where you have placed the et-icon folder*

In the class-fw-option-type-et-icon.php file edit the path on line 158 to the path where you have your ET Line Font style.css file ([Download Et Line Font](http://www.elegantthemes.com/icons/et-line-font.zip)).

**Example:**
```php
'font-style-src' => get_template_directory_uri() . '/assets/fonts/et-line-font/style.css',
```

