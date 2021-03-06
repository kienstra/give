<?php
/**
 * Give Donor Wall Block Class
 *
 * @package     Give
 * @subpackage  Classes/Blocks
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       2.3.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Give_Donor_Wall_Block Class.
 *
 * This class handles donation forms block.
 *
 * @since 2.3.0
 */
class Give_Donor_Wall_Block {
	/**
	 * Instance.
	 *
	 * @since
	 * @access private
	 * @var Give_Donor_Wall_Block
	 */
	static private $instance;

	/**
	 * Singleton pattern.
	 *
	 * @since
	 * @access private
	 */
	private function __construct() {
	}


	/**
	 * Get instance.
	 *
	 * @since
	 * @access public
	 * @return Give_Donor_Wall_Block
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			self::$instance = new static();

			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Class Constructor
	 *
	 * Set up the Give Donation Grid Block class.
	 *
	 * @since  2.3.0
	 * @access private
	 */
	private function init() {
		add_action( 'init', array( $this, 'register_block' ), 999 );
	}

	/**
	 * Register block
	 *
	 * @access public
	 */
	public function register_block() {
		// Bailout.
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		// Register block.
		register_block_type( 'give/donor-wall', array(
			'render_callback' => array( $this, 'render_block' ),
			'attributes'      => array(
				'donorsPerPage' => array(
					'type'    => 'string',
					'default' => '12',
				),
				'formID'        => array(
					'type'    => 'string',
					'default' => '0',
				),
				'order'         => array(
					'type'    => 'string',
					'default' => 'DESC',
				),
				'paged'         => array(
					'type'    => 'string',
					'default' => '1',
				),
				'columns'       => array(
					'type'    => 'string',
					'default' => '2',
				),
				'showAvatar'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showName'      => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showTotal'     => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showDate'      => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showComments'  => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'commentLength' => array(
					'type'    => 'string',
					'default' => '140',
				),
				'onlyComments'  => array(
					'type'    => 'boolean',
					'default' => false,
				),
				'readMoreText'  => array(
					'type'    => 'string',
					'default' => __( 'Read more', 'give' ),
				),
				'loadMoreText'  => array(
					'type'    => 'string',
					'default' => __( 'Load more', 'give' ),
				),
				'avatarSize'    => array(
					'type'    => 'string',
					'default' => '60',
				),
			),
		) );
	}

	/**
	 * Block render callback
	 *
	 * @param array $attributes Block parameters.
	 *
	 * @access public
	 * @return string;
	 */
	public function render_block( $attributes ) {
		$parameters = array(
			'donors_per_page' => absint( $attributes['donorsPerPage'] ),
			'form_id'         => absint( $attributes['formID'] ),
			'order'           => $attributes['order'],
			'pages'           => absint( $attributes['paged'] ),
			'columns'         => absint( $attributes['columns'] ),
			'show_avatar'     => $attributes['showAvatar'],
			'show_name'       => $attributes['showName'],
			'show_total'      => $attributes['showTotal'],
			'show_time'       => $attributes['showDate'],
			'show_comments'   => $attributes['showComments'],
			'comment_length'  => absint( $attributes['commentLength'] ),
			'only_comments'   => $attributes['onlyComments'],
			'readmore_text'   => $attributes['readMoreText'],
			'loadmore_text'   => $attributes['loadMoreText'],
			'avatar_size'     => absint( $attributes['avatarSize'] ),
		);

		return Give_Donor_Wall::get_instance()->render_shortcode( $parameters );
	}
}

Give_Donor_Wall_Block::get_instance();
