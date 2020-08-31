<?php
/**
 * Package for Post Type.
 *
 * @package HAMWORKS\WP
 */

namespace HAMWORKS\WP\Post_Type;

/**
 * Post Type Builder.
 */
class Builder {

	/**
	 * Post type slug.
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Post type name for readable.
	 *
	 * @var string
	 */
	private $label;


	/**
	 * Post type arguments.
	 *
	 * @var array
	 */
	private $args;

	/**
	 * Post type labels.
	 *
	 * @var array
	 */
	private $labels;

	/**
	 * Build Post type.
	 *
	 * @param string $name post type name slug.
	 * @param string $label name for label.
	 */
	public function __construct( $name, $label ) {
		$this->name = $name;
		$this->label = $label;
		$this->set_labels();
		$this->set_options();
	}

	/**
	 * Add hooks.
	 */
	public function create() {
		$this->register_post_type();
		add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
	}

	/**
	 * Post type object getter.
	 *
	 * @return \WP_Post_Type|null
	 */
	public function get_post_type() {
		return get_post_type_object( $this->name );
	}

	/**
	 * Setter Labels.
	 *
	 * @param array $args label dictionary.
	 */
	public function set_labels( $args = array() ) {
		$this->labels = $this->create_labels( $args );
	}

	/**
	 * Create Labels.
	 *
	 * @param array $args label dictionary.
	 *
	 * @return array
	 */
	private function create_labels( $args = array() ) {
		$defaults = array(
			'name'               => $this->label,
			'singular_name'      => $this->label,
			'all_items'          => $this->label . '一覧',
			'add_new'            => '新規追加',
			'add_new_item'       => $this->label . 'を追加',
			'edit_item'          => $this->label . 'を編集',
			'new_item'           => '新しい' . $this->label,
			'view_item'          => $this->label . 'を表示',
			'search_items'       => $this->label . 'を検索',
			'not_found'          => $this->label . 'が見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱の中から、' . $this->label . 'が見つかりませんでした。',
			'menu_name'          => $this->label,
			'archives'           => $this->label,
		);

		return array_merge( $defaults, $args );
	}

	/**
	 * Set Options.
	 *
	 * @param array $args option dictionary.
	 */
	public function set_options( array $args = array() ) {
		$this->args = $this->create_options( $args );
	}

	/**
	 * Create Options.
	 *
	 * @param array $args arguments.
	 *
	 * @return array
	 */
	private function create_options( $args = array() ) {
		$defaults = array(
			'public'            => true,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_in_admin_bar' => true,
			'menu_position'     => null,
			'show_in_nav_menus' => true,
			'has_archive'       => true,
			'rewrite'           => array(
				'with_front' => false,
				'slug'       => $this->name,
				'walk_dirs'  => false,
			),
			'supports'          => array(
				'title',
				'author',
				'editor',
				'excerpt',
				'revisions',
				'thumbnail',
				'custom-fields',
			),
		);

		$args = array_merge( $defaults, $args );

		if ( $args['rewrite'] && empty( $args['rewrite']['walk_dirs'] ) ) {
			$args['rewrite']['walk_dirs'] = false;
		}

		return $args;
	}

	/**
	 * Register Post Type.
	 */
	private function register_post_type() {
		$this->args['labels'] = $this->labels;
		register_post_type( $this->name, $this->args );
	}


	/**
	 * Default order to menu_order in admin.
	 *
	 * @param \WP_Query $query WP_Query instance.
	 */
	public function pre_get_posts( \WP_Query $query ) {
		if ( $query->is_main_query() && is_admin() ) {
			if ( $query->get( 'post_type' ) === $this->name ) {
				if ( post_type_supports( $this->name, 'page-attributes' ) ) {
					if ( empty( $query->query['order'] ) ) {
						$query->set( 'order', 'ASC' );
					}

					if ( empty( $query->query['orderby'] ) ) {
						$query->set( 'orderby', 'menu_order' );
					}
				}
			}
		}
	}

}


