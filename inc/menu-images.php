<?php

/**
 * Functions that add images to menu items
 *
 * @package DPD_2015
 * @author Slushman <chris@slushman.com>
 */
class dpd_2015_Menu_Image {

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->loader();

	} // __construct()

	/**
	 * Loads all filter and action calls
	 *
	 * @return 		void
	 */
	private function loader() {

		add_action( 'init', array( $this, 'menu_image_init' ), 99 );
		add_action( 'admin_action_delete-menu-item-image', array( $this, 'delete_menu_item_image_action' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts_and_styles' ), 1 );
		add_action( 'save_post_nav_menu_item', array( $this, 'save_post_action' ), 10, 3 );
		//add_action( 'wp_ajax_set-menu-item-thumbnail', array( $this, 'wp_ajax_set_menu_item_thumbnail' ) );
		add_filter( 'wp_setup_nav_menu_item', array( $this, 'wp_setup_nav_menu_item' ) );

	} // loader()

	/**
	 * Loading media-editor script to nav-menus page.
	 *
	 * @since 2.0
	 */
	public function admin_scripts_and_styles( $hook ) {

		if ( 'nav-menus.php' != $hook ) { return; }

		wp_enqueue_script( 'dpd-2015-menu-image-admin', get_stylesheet_directory_uri() . '/js/menu-images.min.js', array( 'jquery' ) );
		wp_localize_script(
			'dpd-2015-menu-image-admin', 'menuImage', array(
				'l10n'     => array(
					'uploaderTitle' 		=> __( 'Choose image', 'tillotson' ),
					'uploaderButtonText' 	=> __( 'Select', 'tillotson' ),
					'removeLabel' 			=> __( 'Remove image', 'tillotson' ),
					'setLabel' 				=> __( 'Set image', 'tillotson' )
				),
				'settings' => array(
					'nonce' => wp_create_nonce( 'update-menu-item' ),
				),
			)
		);
		wp_enqueue_media();
		wp_enqueue_style( 'editor-buttons' );

	} // admin_scripts_and_styles()

	/**
	 * Admin init action with lowest execution priority
	 */
	public function admin_init() {

		if ( ! has_action( 'wp_nav_menu_item_custom_fields' ) ) {

			add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_nav_menu_walker_filter' ), 10, 2  );

		}

		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'menu_item_icon' ), 10, 1 );
		add_action( 'wp_nav_menu_item_custom_fields', array( $this, 'menu_item_image' ), 15, 1 );

	} // admin_init()

	/**
	 * When menu item removed remove menu image metadata.
	 */
	public function delete_menu_item_image_action() {

		$menu_item_id = (int) $_REQUEST[ 'menu-item' ];

		check_admin_referer( 'delete-menu_item_image_' . $menu_item_id );

		if ( is_nav_menu_item( $menu_item_id ) && has_post_thumbnail( $menu_item_id ) ) {

			delete_post_thumbnail( $menu_item_id );
			delete_post_meta( $menu_item_id, 'menu_item_icon' );
			delete_post_meta( $menu_item_id, 'menu-item-bg-img' );

		}

	} // delete_menu_item_image_action()

	/**
	 * Replacement edit menu walker class.
	 *
	 * @return string
	 */
	public function edit_nav_menu_walker_filter( $walker, $menu_id ) {

		if ( empty( $menu_id ) ) { return $walker; }

		return 'Menu_Images_Walker_Nav_Menu_Edit';

	} // edit_nav_menu_walker_filter()

	/**
	 * Returns an array of the all the metabox fields and their respective types
	 *
	 * $fields[] 	= array( 'field-name', 'field-type', 'Field Label' );
	 *
	 * @since 		1.0.0
	 * @access 		public
	 * @return 		array 		Metabox fields and types
	 */
	public static function get_meta_fields() {

		$fields = array();

		$fields[] 	= array( 'menu_item_icon', 'select' );
		$fields[] 	= array( 'menu-item-bg-img', 'hidden' );

		return $fields;

	} // get_meta_fields()

	/**
	 * Check if attachment is used in menu items.
	 *
	 * @param string $size
	 * @param int    $id
	 *
	 * @return bool
	 */
	public function isAttachmentUsed( $size, $id ) {

		return is_string($size) && isset( $this->used_attachments[ $size ] ) && in_array( $id, $this->used_attachments[ $size ] );

	} // isAttachmentUsed()

	/**
	 * Initialization action.
	 *
	 * Adding image sizes for most popular menu icon sizes. Adding thumbnail
	 *  support to menu post type.
	 */
	public function menu_image_init() {

		add_post_type_support( 'nav_menu_item', array( 'thumbnail' ) );

	} // menu_image_init()

	/**
	 * Add icon field to menu item.
	 *
	 * @see ttp://shazdeh.me/2014/06/25/custom-fields-nav-menu-items/
	 */
	public function menu_item_icon( $item_id ) {

		global $dpd_2015_themekit;

		$content 	= '';
		$icon 		= get_post_meta( $item_id, 'menu_item_icon', true );
		$svgs 		= $dpd_2015_themekit->get_svg_list();

		ob_start();

		?><label for="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>"><?php _e( 'Icon', 'dpd-2015' );
			?><br />
			<select id="edit-menu-item-icon-<?php echo esc_attr( $item_id ); ?>"
					class="edit-menu-item-icon"
					name="menu_item_icon[<?php echo $item_id; ?>]">
				<option value="" selected="selected"></option><?php

				foreach ( $svgs as $key => $svg ) :

					$replaced = str_replace( '-', ' ', $key );

					?><option value="<?php echo esc_attr( $key ); ?>" <?php echo selected( $icon, $key, false ); ?>><?php echo ucwords( $replaced ); ?></option><?php

				endforeach;

			?></select>
		</label><?php

		$content = "<p class='menu-item-images' style='min-height:70px'>$content</p>" . ob_get_clean();

		echo $content;

	} // menu_item_icon()

	/**
	 * Add image field to menu item.
	 *
	 * @see ttp://shazdeh.me/2014/06/25/custom-fields-nav-menu-items/
	 */
	public function menu_item_image( $item_id ) {

		global $dpd_2015_themekit;

		$content 		= '';
		$thumbnail_id 	= get_post_meta( $item_id, 'menu-item-bg-img', true );

		ob_start();

		?><p class="menu-item-images" id="menu-item-img-<?php echo esc_attr( $item_id ); ?>">
			<label for="menu-item-bg-img-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Background Image', 'dpd-2015' ); ?><br />
				<img class="menu-item-bg-img" src="<?php

				if ( ! empty( $thumbnail_id ) ) {

					echo esc_url( wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' )[0] );

				}

				?>" />
				<a class="menu-bg-img-btn button wp-media-buttons remove-btn<?php

					if ( empty( $thumbnail_id ) ) { echo esc_attr( ' hide' ); }

				?>" data-item-id="<?php echo esc_attr( $item_id ); ?>" href="#" id="post-thumbnail-<?php

					echo esc_attr( $item_id );

				?>"><?php esc_html_e( 'Remove image', 'dpd-2015' ); ?></a>
				<a class="menu-bg-img-btn button wp-media-buttons set-btn<?php

					if ( ! empty( $thumbnail_id ) ) { echo esc_attr( ' hide' ); }

				?>" data-item-id="<?php echo esc_attr( $item_id ); ?>" href="#" id="post-thumbnail-<?php

					echo esc_attr( $item_id );

				?>"><?php esc_html_e( 'Set image', 'dpd-2015' ); ?></a>
			<input id="_menu-item-bg-img-<?php echo esc_attr( $item_id ); ?>" name="menu-item-bg-img[<?php echo esc_attr( $item_id ); ?>]" type="hidden" value="<?php

			if ( ! empty( $thumbnail_id ) ) {

				echo esc_attr( $thumbnail_id );

			}

			?>">
			</label>
		</p><?php

		$content = ob_get_clean();

		echo $content;

	} // menu_item_image()

	/**
	 * Saving post action.
	 *
	 * Saving uploaded images and attach/detach to image post type.
	 *
	 * @param int     $post_id
	 * @param WP_Post $post
	 */
	public function save_post_action( $post_id, $post ) {

		//wp_die( print_r( $_POST ) );

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return $post_id; }
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) { return $post_id; }
		if ( ! current_user_can( 'edit_theme_options', $post_id ) ) { return $post_id; }
		if ( 'nav_menu_item' != $post->post_type ) { return $post_id; }

		require_once get_stylesheet_directory() . '/inc/sanitizer.php';

		$settings 	= $this->get_meta_fields();
		$meta 		= get_post_custom( $post->ID );

		foreach ( $settings as $setting ) {

			$value 		= ( empty( $meta[$setting[0]][0] ) ? '' : $meta[$setting[0]][0] );
			$sanitizer 	= new dpd_2015_Sanitize();

			$sanitizer->set_data( $_POST[$setting[0]][$post_id] );
			$sanitizer->set_type( $setting[1] );

			$new_value = $sanitizer->clean();

			update_post_meta( $post_id, $setting[0], $new_value );

			unset( $sanitizer );

		} // foreach

	} // save_post_action()

	/**
	 * Set used attachment ids.
	 *
	 * @param string $size
	 * @param int    $id
	 */
	public function setUsedAttachments( $size, $id ) {

		$this->used_attachments[ $size ][ ] = $id;

	} // setUsedAttachments()

	/**
	 * Load menu image meta for each menu item.
	 */
	public function wp_setup_nav_menu_item( $item ) {

		if ( ! isset( $item->thumbnail_id ) ) {

			$item->thumbnail_id = get_post_thumbnail_id( $item->ID );

		}

		if ( ! isset( $item->icon ) ) {

			$item->icon = get_post_meta( $item->ID, 'menu_item_icon', true );

		}

		return $item;

	} // wp_setup_nav_menu_item()

} // class

$menu_images = new dpd_2015_Menu_Image();

require_once(ABSPATH . 'wp-admin/includes/nav-menu.php');

class Menu_Images_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $_wp_nav_menu_max_depth;
		$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

		ob_start();
		$item_id = esc_attr( $item->ID );
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		);

		$original_title = '';
		if ( 'taxonomy' == $item->type ) {
			$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
			if ( is_wp_error( $original_title ) )
				$original_title = false;
		} elseif ( 'post_type' == $item->type ) {
			$original_object = get_post( $item->object_id );
			$original_title = get_the_title( $original_object->ID );
		}

		$classes = array(
			'menu-item menu-item-depth-' . $depth,
			'menu-item-' . esc_attr( $item->object ),
			'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive'),
		);

		$title = $item->title;

		if ( ! empty( $item->_invalid ) ) {
			$classes[] = 'menu-item-invalid';
			/* translators: %s: title of menu item which is invalid */
			$title = sprintf( __( '%s (Invalid)' ), $item->title );
		} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
			$classes[] = 'pending';
			/* translators: %s: title of menu item in draft status */
			$title = sprintf( __('%s (Pending)'), $item->title );
		}

		$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

		$submenu_text = '';
		if ( 0 == $depth )
			$submenu_text = 'style="display: none;"';

		?>
		<li id="menu-item-<?php echo $item_id; ?>" class="<?php echo implode(' ', $classes ); ?>">
			<dl class="menu-item-bar">
				<dt class="menu-item-handle">
					<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span class="is-submenu" <?php echo $submenu_text; ?>><?php _e( 'sub item' ); ?></span></span>
					<span class="item-controls">
						<span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
						<span class="item-order hide-if-js">
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-up-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-up"><abbr title="<?php esc_attr_e('Move up'); ?>">&#8593;</abbr></a>
							|
							<a href="<?php
								echo wp_nonce_url(
									add_query_arg(
										array(
											'action' => 'move-down-menu-item',
											'menu-item' => $item_id,
										),
										remove_query_arg($removed_args, admin_url( 'nav-menus.php' ) )
									),
									'move-menu_item'
								);
							?>" class="item-move-down"><abbr title="<?php esc_attr_e('Move down'); ?>">&#8595;</abbr></a>
						</span>
						<a class="item-edit" id="edit-<?php echo $item_id; ?>" title="<?php esc_attr_e('Edit Menu Item'); ?>" href="<?php
							echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item', $item_id, remove_query_arg( $removed_args, admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
						?>"><?php _e( 'Edit Menu Item' ); ?></a>
					</span>
				</dt>
			</dl>

			<div class="menu-item-settings" id="menu-item-settings-<?php echo $item_id; ?>">
				<?php if( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo $item_id; ?>">
							<?php _e( 'URL' ); ?><br />
							<input type="text" id="edit-menu-item-url-<?php echo $item_id; ?>" class="widefat code edit-menu-item-url" name="menu-item-url[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->url ); ?>" />
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-thin">
					<label for="edit-menu-item-title-<?php echo $item_id; ?>">
						<?php _e( 'Navigation Label' ); ?><br />
						<input type="text" id="edit-menu-item-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-title" name="menu-item-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->title ); ?>" />
					</label>
				</p>
				<p class="field-title-attribute description description-thin">
					<label for="edit-menu-item-attr-title-<?php echo $item_id; ?>">
						<?php _e( 'Title Attribute' ); ?><br />
						<input type="text" id="edit-menu-item-attr-title-<?php echo $item_id; ?>" class="widefat edit-menu-item-attr-title" name="menu-item-attr-title[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->post_excerpt ); ?>" />
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo $item_id; ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo $item_id; ?>" value="_blank" name="menu-item-target[<?php echo $item_id; ?>]"<?php checked( $item->target, '_blank' ); ?> />
						<?php _e( 'Open link in a new window/tab' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo $item_id; ?>">
						<?php _e( 'CSS Classes (optional)' ); ?><br />
						<input type="text" id="edit-menu-item-classes-<?php echo $item_id; ?>" class="widefat code edit-menu-item-classes" name="menu-item-classes[<?php echo $item_id; ?>]" value="<?php echo esc_attr( implode(' ', $item->classes ) ); ?>" />
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo $item_id; ?>">
						<?php _e( 'Link Relationship (XFN)' ); ?><br />
						<input type="text" id="edit-menu-item-xfn-<?php echo $item_id; ?>" class="widefat code edit-menu-item-xfn" name="menu-item-xfn[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->xfn ); ?>" />
					</label>
				</p><?php

				/**
				 * The wp_nav_menu_item_custom_fields action hook
				 */
				do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );

				?><p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo $item_id; ?>">
						<?php _e( 'Description' ); ?><br />
						<textarea id="edit-menu-item-description-<?php echo $item_id; ?>" class="widefat edit-menu-item-description" rows="3" cols="20" name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span class="description"><?php _e('The description will be displayed in the menu if the current theme supports it.'); ?></span>
					</label>
				</p>

				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php _e( 'Move' ); ?></span>
						<a href="#" class="menus-move menus-move-up" data-dir="up"><?php _e( 'Up one' ); ?></a>
						<a href="#" class="menus-move menus-move-down" data-dir="down"><?php _e( 'Down one' ); ?></a>
						<a href="#" class="menus-move menus-move-left" data-dir="left"></a>
						<a href="#" class="menus-move menus-move-right" data-dir="right"></a>
						<a href="#" class="menus-move menus-move-top" data-dir="top"><?php _e( 'To the top' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __('Original: %s'), '<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo $item_id; ?>" href="<?php
					echo wp_nonce_url(
						add_query_arg(
							array(
								'action' => 'delete-menu-item',
								'menu-item' => $item_id,
							),
							admin_url( 'nav-menus.php' )
						),
						'delete-menu_item_' . $item_id
					); ?>"><?php _e( 'Remove' ); ?></a> <span class="meta-sep hide-if-no-js"> | </span> <a class="item-cancel submitcancel hide-if-no-js" id="cancel-<?php echo $item_id; ?>" href="<?php echo esc_url( add_query_arg( array( 'edit-menu-item' => $item_id, 'cancel' => time() ), admin_url( 'nav-menus.php' ) ) );
						?>#menu-item-settings-<?php echo $item_id; ?>"><?php _e('Cancel'); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden" name="menu-item-db-id[<?php echo $item_id; ?>]" value="<?php echo $item_id; ?>" />
				<input class="menu-item-data-object-id" type="hidden" name="menu-item-object-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object_id ); ?>" />
				<input class="menu-item-data-object" type="hidden" name="menu-item-object[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->object ); ?>" />
				<input class="menu-item-data-parent-id" type="hidden" name="menu-item-parent-id[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_item_parent ); ?>" />
				<input class="menu-item-data-position" type="hidden" name="menu-item-position[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->menu_order ); ?>" />
				<input class="menu-item-data-type" type="hidden" name="menu-item-type[<?php echo $item_id; ?>]" value="<?php echo esc_attr( $item->type ); ?>" />
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
		<?php
		$output .= ob_get_clean();
	}
}
