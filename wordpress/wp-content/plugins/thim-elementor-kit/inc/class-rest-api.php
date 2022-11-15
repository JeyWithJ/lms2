<?php
namespace Thim_EL_Kit;

use Thim_EL_Kit\Utilities\Rest_Response;
use Thim_EL_Kit\Custom_Post_Type;

class Rest_API {
	use SingletonTrait;

	const NAMESPACE = 'thim-ekit';

	const META_KEY_CONDITIONS = array( 'entire', 'archive', 'archiveList', 'singular', 'singularList', 'page', 'pageList', '404', 'realpress-agent' ); // Cannot change stt

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_endpoints' ) );
	}

	public function register_endpoints() {
		register_rest_route(
			self::NAMESPACE,
			'/create-template',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'create_template' ),
				'permission_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_rest_route(
			self::NAMESPACE,
			'/update-template',
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'update_template' ),
				'permission_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_rest_route(
			self::NAMESPACE,
			'/get-template',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_template' ),
				'permission_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		register_rest_route(
			self::NAMESPACE,
			'/get-posts',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_posts' ),
				'permission_callback' => function() {
					return current_user_can( 'edit_posts' );
				},
			)
		);

		do_action( 'thim_ekit/rest_api/register_endpoints', self::NAMESPACE );
	}

	public function get_posts( \WP_REST_Request $request ) {
		$query_args = array(
			'post_type'      => $request['post_type'] ?? 'post',
			'post_status'    => 'publish',
			'posts_per_page' => 15,
		);

		if ( isset( $request['ids'] ) ) {
			$ids                    = explode( ',', $request['ids'] );
			$query_args['post__in'] = $ids;
		}

		if ( isset( $request['s'] ) ) {
			$query_args['s'] = $request['s'];
		}

		$query = new \WP_Query( $query_args );

		$options = array();

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$options[] = array(
					'id'   => get_the_ID(),
					'text' => get_the_title(),
				);
			}
		}

		wp_reset_postdata();

		return array( 'results' => $options );
	}

	public function get_condition_meta( $id ) {
		$lists = self::META_KEY_CONDITIONS;

		$output = array();
		foreach ( $lists as $list ) {
			$meta = get_post_meta( $id, 'thim_ekits_cond_' . $list, true );

			if ( $meta ) {
				$output[ $list ] = $meta;
			}
		}

		return $output;
	}

	public function update_condition_meta( $id, $conditions ) {
		$lists = self::META_KEY_CONDITIONS;

		foreach ( $lists as $list ) {
			$meta = get_post_meta( $id, 'thim_ekits_cond_' . $list, true );

			if ( isset( $conditions[ $list ] ) ) {
				update_post_meta( $id, 'thim_ekits_cond_' . $list, $conditions[ $list ] );
			} elseif ( $meta ) {
				delete_post_meta( $id, 'thim_ekits_cond_' . $list );
			}
		}
	}

	public function get_template( \WP_REST_Request $request ) {
		$response = new Rest_Response();

		$id = ! empty( $request['id'] ) ? absint( $request['id'] ) : '';

		try {
			if ( empty( $id ) ) {
				throw new \Exception( esc_html__( 'No ID params', 'thim-elementor-kit' ) );
			}

			$post = get_post( $id );

			if ( ! $post ) {
				throw new \Exception( esc_html__( 'Template is not available', 'thim-elementor-kit' ) );
			}

			$conditions = $this->get_condition_meta( $id );

			$response->status           = 'success';
			$response->data->title      = $post->post_title ?? '';
			$response->data->sticky     = get_post_meta( $id, 'thim_elementor_sticky', true );
			$response->data->conditions = $conditions;
		} catch ( \Throwable $th ) {
			$response->message = $th->getMessage();
		}

		return rest_ensure_response( $response );
	}

	public function create_template( \WP_REST_Request $request ) {
		$response = new Rest_Response();

		$type      = ! empty( $request['type'] ) ? $request['type'] : '';
		$name      = ! empty( $request['name'] ) ? $request['name'] : '';
		$condition = ! empty( $request['condition'] ) ? $request['condition'] : '';
		$sticky    = ! empty( $request['sticky'] ) ? $request['sticky'] : false;

		try {
			if ( empty( $name ) ) {
				throw new \Exception( esc_html__( 'Please enter template name', 'thim-elementor-kit' ) );
			}

			$args = apply_filters(
				'thim_ekit/rest_api/create_template/args',
				array(
					'post_title'  => $name,
					'post_type'   => Custom_Post_Type::CPT,
					'post_status' => 'publish',
					'meta_input'  => array(
						'_elementor_edit_mode' => 'builder',
					),
				)
			);

			if ( ! empty( $type ) ) {
				$args['meta_input']['thim_elementor_type'] = $type;
			}

			$id = wp_insert_post( $args );

			if ( is_wp_error( $id ) ) {
				throw new \Exception( esc_html__( 'Cannot insert template', 'thim-elementor-kit' ) );
			}

			if ( $type === 'header' ) {
				update_post_meta( $id, 'thim_elementor_sticky', $sticky );
			}

			if ( ! empty( $condition ) ) {
				$this->update_condition_meta( $id, $condition );
			}

			$url = add_query_arg(
				array(
					'post'   => $id,
					'action' => 'elementor',
				),
				admin_url( 'post.php' )
			);

			$response->status         = 'success';
			$response->data->id       = $id;
			$response->data->redirect = $url;
			$response->message        = esc_html__( 'Create template successfully, Redirecting...', 'thim-elementor-kit' );
		} catch ( \Throwable $th ) {
			$response->message = $th->getMessage();
		}

		return rest_ensure_response( $response );
	}

	public function update_template( \WP_REST_Request $request ) {
		$response = new Rest_Response();

		$id        = ! empty( $request['id'] ) ? absint( $request['id'] ) : '';
		$name      = ! empty( $request['name'] ) ? $request['name'] : '';
		$condition = ! empty( $request['condition'] ) ? $request['condition'] : '';
		$sticky    = ! empty( $request['sticky'] ) ? $request['sticky'] : false;

		try {
			if ( empty( $name ) || empty( $id ) ) {
				throw new \Exception( esc_html__( 'Invalid params', 'thim-elementor-kit' ) );
			}

			$args = apply_filters(
				'thim_ekit/rest_api/update_template/args',
				array(
					'ID'         => $id,
					'post_title' => $name,
					'post_type'  => Custom_Post_Type::CPT,
				)
			);

			$update_id = wp_update_post( $args );

			if ( is_wp_error( $update_id ) ) {
				throw new \Exception( esc_html__( 'Cannot insert template', 'thim-elementor-kit' ) );
			}

			update_post_meta( $update_id, 'thim_elementor_sticky', $sticky );

			$this->update_condition_meta( $update_id, $condition );

			$url = add_query_arg(
				array(
					'post'   => $id,
					'action' => 'elementor',
				),
				admin_url( 'post.php' )
			);

			$response->status   = 'success';
			$response->data->id = $update_id;
			// $response->data->redirect = $url;
			$response->message = esc_html__( 'Update template successfully', 'thim-elementor-kit' );
		} catch ( \Throwable $th ) {
			$response->message = $th->getMessage();
		}

		return rest_ensure_response( $response );
	}
}

Rest_API::instance();
