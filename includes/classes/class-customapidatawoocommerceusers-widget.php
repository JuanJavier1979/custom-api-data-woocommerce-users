<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
/**
 * Widget functionality class.
 *
 * @package CustomApiDataWoocommerceUsers
 */

class CustomApiDataWoocommerceUsers_Widget extends WP_Widget {
	/**
	 * Sets up the widgets name.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'custom-api-data-woocommerce-users-widget',
			'description' => __( 'Add Saved API data for each WooCommerce user', 'custom-api-data-woocommerce-users' ),
		);

		parent::__construct( 'custom_api_data_woocommerce_users', __( 'Custom Api Data Woocommerce Users', 'custom-api-data-woocommerce-users' ), $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo esc_html( get_user_meta( get_current_user_id(), 'custom_return_data', true ) );
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'custom-api-data-woocommerce-users' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'custom-api-data-woocommerce-users' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		foreach ( $new_instance as $key => $value ) {
			$updated_instance[ $key ] = sanitize_text_field( $value );
		}

		return $updated_instance;
	}
}
