<?php if (!defined('FW')) die('Forbidden');

class FW_Option_Type_Et_Icon extends FW_Option_Type
{
	/**
	 * Prevent enqueue same font style twice, in case it is used in multiple sets
	 * @var array
	 */
	private $enqueued_font_styles = array();

	public function get_type()
	{
		return 'et-icon';
	}

	/**
	 * @internal
	 */
	public function _get_backend_width_type()
	{
		return 'full';
	}

	/**
	 * @internal
	 * {@inheritdoc}
	 */
	protected function _enqueue_static($id, $option, $data)
	{
		wp_enqueue_style(
			'fw-option-type-'. $this->get_type() .'-backend',
			get_template_directory_uri() . '/inc/includes/option-types/'. $this->get_type() .'/static/css/backend.css',
			fw()->manifest->get_version()
		);

		wp_enqueue_script(
			'fw-option-type-'. $this->get_type() .'-backend',
			get_template_directory_uri() . '/inc/includes/option-types/'. $this->get_type() .'/static/js/backend.js',
			array('jquery', 'fw-events'),
			fw()->manifest->get_version()
		);

		$sets = $this->get_sets();

		if (isset($sets[ $option['set'] ])) {
			$set = $sets[ $option['set'] ];

			unset($sets);

			/**
			 * user hash as array key instead of src, because src can be a very long data-url string
			 */
			$style_hash = md5($set['font-style-src']);

			if (!isset($this->enqueued_font_styles[ $style_hash ])) {
				wp_enqueue_style(
					"fw-option-type-{$this->get_type()}-font-{$option['set']}",
					$set['font-style-src'],
					array(),
					fw()->manifest->get_version()
				);

				$this->enqueued_font_styles[ $style_hash ] = true;
			}
		}
	}

	/**
	 * @internal
	 */
	protected function _render($id, $option, $data)
	{
		$sets = $this->get_sets();

		if (isset($sets[ $option['set'] ])) {
			$set = $sets[ $option['set'] ];
		} else {
			$set = $this->generate_unknown_set($data['value']);
		}

		unset($sets);

		$option['attr']['value'] = (string)$data['value'];

		return fw_render_view(dirname(__FILE__) . '/view.php', compact('id', 'option', 'data', 'set'));
	}

	/**
	 * @internal
	 */
	protected function _get_value_from_input($option, $input_value)
	{
		$sets = $this->get_sets();

		if (isset($sets[ $option['set'] ])) {
			$set = $sets[ $option['set'] ];
		} else {
			$set = $this->generate_unknown_set($input_value);
		}

		unset($sets);

		if (is_null($input_value) || !isset($set['et-icons'][ $input_value ])) {
			$input_value = $option['value'];
		}

		return (string)$input_value;
	}

	/**
	 * @internal
	 */
	protected function _get_defaults()
	{
		return array(
			'value' => '',
			'set'   => 'et-icons',
		);
	}

	private function get_sets()
	{
		$cache_key = 'fw_option_type_et_icon/sets';

		try {
			return FW_Cache::get($cache_key);
		} catch (FW_Cache_Not_Found_Exception $e) {
			$sets = apply_filters('fw_option_type_et_icon_sets', $this->get_default_sets());

			// do not allow overwrite default sets
			$sets = array_merge($sets, $this->get_default_sets());

			FW_Cache::set($cache_key, $sets);

			return $sets;
		}
	}

	private function generate_unknown_set($icon)
	{
		return array(
			'font-style-src'  => 'data:text/css;charset=utf-8;base64,LyoqLw==',
			'container-class' => '',
			'groups' => array(
				'unknown' => __('Unknown Set', 'fw'),
			),
			'et-icons' => array(
				$icon => array('group' => 'unknown'),
			),
		);
	}

	private function get_default_sets()
	{

		return array(
			'et-icons' => array( // site: https://github.com/pprince/etlinefont-bower, download: http://www.elegantthemes.com/icons/et-line-font.zip
				'font-style-src' => get_template_directory_uri() . '/assets/fonts/et-line-font/style.css',
				'container-class' => 'fa-lg', // some fonts need special wrapper class to display properly
				'groups' => array(
					'all' => __('All ET Line Icons', 'fw'),
				),
				'et-icons' => array(
					// All Icons
					'icon-mobile' => array('group' => 'all'),
					'icon-laptop' => array('group' => 'all'),
					'icon-desktop' => array('group' => 'all'),
					'icon-tablet' => array('group' => 'all'),
					'icon-phone' => array('group' => 'all'),
					'icon-document' => array('group' => 'all'),
					'icon-documents' => array('group' => 'all'),
					'icon-search' => array('group' => 'all'),
					'icon-clipboard' => array('group' => 'all'),
					'icon-newspaper' => array('group' => 'all'),
					'icon-notebook' => array('group' => 'all'),
					'icon-book-open' => array('group' => 'all'),
					'icon-browser' => array('group' => 'all'),
					'icon-calendar' => array('group' => 'all'),
					'icon-presentation' => array('group' => 'all'),
					'icon-picture' => array('group' => 'all'),
					'icon-pictures' => array('group' => 'all'),
					'icon-video' => array('group' => 'all'),
					'icon-camera' => array('group' => 'all'),
					'icon-printer' => array('group' => 'all'),
					'icon-toolbox' => array('group' => 'all'),
					'icon-briefcase' => array('group' => 'all'),
					'icon-wallet' => array('group' => 'all'),
					'icon-gift' => array('group' => 'all'),
					'icon-bargraph' => array('group' => 'all'),
					'icon-grid' => array('group' => 'all'),
					'icon-expand' => array('group' => 'all'),
					'icon-focus' => array('group' => 'all'),
					'icon-edit' => array('group' => 'all'),
					'icon-adjustments' => array('group' => 'all'),
					'icon-ribbon' => array('group' => 'all'),
					'icon-hourglass' => array('group' => 'all'),
					'icon-lock' => array('group' => 'all'),
					'icon-megaphone' => array('group' => 'all'),
					'icon-shield' => array('group' => 'all'),
					'icon-trophy' => array('group' => 'all'),
					'icon-flag' => array('group' => 'all'),
					'icon-map' => array('group' => 'all'),
					'icon-puzzle' => array('group' => 'all'),
					'icon-basket' => array('group' => 'all'),
					'icon-envelope' => array('group' => 'all'),
					'icon-streetsign' => array('group' => 'all'),
					'icon-telescope' => array('group' => 'all'),
					'icon-gears' => array('group' => 'all'),
					'icon-key' => array('group' => 'all'),
					'icon-paperclip' => array('group' => 'all'),
					'icon-attachment' => array('group' => 'all'),
					'icon-pricetags' => array('group' => 'all'),
					'icon-lightbulb' => array('group' => 'all'),
					'icon-layers' => array('group' => 'all'),
					'icon-pencil' => array('group' => 'all'),
					'icon-tools' => array('group' => 'all'),
					'icon-tools-2' => array('group' => 'all'),
					'icon-scissors' => array('group' => 'all'),
					'icon-paintbrush' => array('group' => 'all'),
					'icon-magnifying-glass' => array('group' => 'all'),
					'icon-circle-compass' => array('group' => 'all'),
					'icon-linegraph' => array('group' => 'all'),
					'icon-mic' => array('group' => 'all'),
					'icon-strategy' => array('group' => 'all'),
					'icon-beaker' => array('group' => 'all'),
					'icon-caution' => array('group' => 'all'),
					'icon-recycle' => array('group' => 'all'),
					'icon-anchor' => array('group' => 'all'),
					'icon-profile-male' => array('group' => 'all'),
					'icon-profile-female' => array('group' => 'all'),
					'icon-bike' => array('group' => 'all'),
					'icon-wine' => array('group' => 'all'),
					'icon-hotairballoon' => array('group' => 'all'),
					'icon-globe' => array('group' => 'all'),
					'icon-genius' => array('group' => 'all'),
					'icon-map-pin' => array('group' => 'all'),
					'icon-dial' => array('group' => 'all'),
					'icon-chat' => array('group' => 'all'),
					'icon-heart' => array('group' => 'all'),
					'icon-cloud' => array('group' => 'all'),
					'icon-upload' => array('group' => 'all'),
					'icon-download' => array('group' => 'all'),
					'icon-target' => array('group' => 'all'),
					'icon-hazardous' => array('group' => 'all'),
					'icon-piechart' => array('group' => 'all'),
					'icon-speedometer' => array('group' => 'all'),
					'icon-global' => array('group' => 'all'),
					'icon-compass' => array('group' => 'all'),
					'icon-lifesaver' => array('group' => 'all'),
					'icon-clock' => array('group' => 'all'),
					'icon-aperture' => array('group' => 'all'),
					'icon-quote' => array('group' => 'all'),
					'icon-scope' => array('group' => 'all'),
					'icon-alarmclock' => array('group' => 'all'),
					'icon-refresh' => array('group' => 'all'),
					'icon-happy' => array('group' => 'all'),
					'icon-sad' => array('group' => 'all'),
					'icon-facebook' => array('group' => 'all'),
					'icon-twitter' => array('group' => 'all'),
					'icon-googleplus' => array('group' => 'all'),
					'icon-rss' => array('group' => 'all'),
					'icon-tumblr' => array('group' => 'all'),
					'icon-linkedin' => array('group' => 'all'),
					'icon-dribbble' => array('group' => 'all'),
				),
			),
		);
	}
}
FW_Option_Type::register('FW_Option_Type_Et_Icon');
