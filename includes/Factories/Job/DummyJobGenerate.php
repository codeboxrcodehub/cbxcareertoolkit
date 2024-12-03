<?php

namespace Cbx\Careertoolkit\Factories\Job;

use Cocur\Slugify\Slugify;
use Cbx\Careertoolkit\Factories\Factory;
use Faker\Factory as FakerFactory;
use WP_User_Query;

/**
 * Dummy job data generate command
 * Class DummyJobGenerate
 * @since 1.0.0
 */
class DummyJobGenerate extends Factory {

	/**
	 * Register CLI command
	 * @since 1.0.0
	 */
	public function wp_cli_register_commands() {
		\WP_CLI::add_command( 'comfortjob-generate', [ $this, "run" ] );
	} //end method wp_cli_register_commands

	/**
	 * Command activity
	 *
	 * @param $args
	 * @param $assoc_args
	 *
	 * @since 1.0.0
	 */
	public function run( $args, $assoc_args ) {
		$start = microtime( true );

		$total       = isset( $assoc_args['total'] ) && intval( $assoc_args['total'] ) ? intval( $assoc_args['total'] ) : 20;
		$status      = isset( $assoc_args['status'] ) ? sanitize_text_field( $assoc_args['status'] ) : 'published';
		$is_remote   = isset( $assoc_args['is-remote'] ) && intval( $assoc_args['is-remote'] ) ? intval( $assoc_args['is-remote'] ) : 0;
		$is_featured = isset( $assoc_args['is-featured'] ) && intval( $assoc_args['is-featured'] ) ? intval( $assoc_args['is-featured'] ) : 1;
		$is_filled   = isset( $assoc_args['is-filled'] ) && intval( $assoc_args['is-filled'] ) ? intval( $assoc_args['is-filled'] ) : 0;

		$salary_currency = isset( $assoc_args['currency'] ) ? sanitize_text_field( $assoc_args['currency'] ) : 'USD';
		$salary_unit     = isset( $assoc_args['salary-unit'] ) ? sanitize_text_field( $assoc_args['salary-unit'] ) : 'monthly';

		$user_id = isset( $assoc_args['user-id'] ) && intval( $assoc_args['user-id'] ) ? intval( $assoc_args['user-id'] ) : 0;

		if ( $user_id == 0 ) {
			// Query for the first user with the Administrator role
			$user_query = new WP_User_Query( [
				'role'    => 'Administrator',
				'orderby' => 'ID',
				'order'   => 'ASC',
				'number'  => 1,
			] );

			// Get the results
			$users = $user_query->get_results();

			//write_log($users);

			// Check if any users are found and output the first user's ID
			if ( ! empty( $users ) ) {
				$user_id = $users[0]->ID;

			}
		}


		if($user_id > 0){
			for ( $i = 0; $i < $total; $i ++ ) {
				$user_data = get_userdata( $user_id );

				$job = [];
				$job['add_by']   = $user_id;
				$job['owner']   = $user_id;
				$job['add_date'] = date( 'Y-m-d H:i:s' );
				//$job['email'] = FakerFactory::create()->email();
				$job['email']           = $user_data->user_email;
				$job['title']           = FakerFactory::create()->jobTitle();
				$job['status']          = $status;
				$job['job_location']    = FakerFactory::create()->address();
				$job['is_featured']     = $is_featured;
				$job['is_filled']       = $is_filled;
				$job['salary_amount']   = FakerFactory::create()->randomNumber( 3 );
				$job['is_remote']       = $is_remote;
				$job['application_url'] = FakerFactory::create()->url();
				$job['description']     = FakerFactory::create()->text();
				$job['open_positions']  = FakerFactory::create()->randomNumber( 1 );

				$job['misc'] = [
					'salary_currency'     => $salary_currency,
					'job_location'        => FakerFactory::create()->address(),
					'company_name'        => FakerFactory::create()->company(),
					'salary_unit'         => $salary_unit,
					'company_website'     => FakerFactory::create()->url(),
					'company_logo'        => '',
					'company_logo_source' => 'job',
					'company_logo_url'    => FakerFactory::create()->imageUrl( 360, 360, 'company', true ),
				];


				//$job['mod_by'] = $job->post_author;
				$job['mod_date'] = date( 'Y-m-d H:i:s' );
				$job['closing_date'] = date( 'Y-m-d H:i:s', strtotime( '+7 days' ) );
				$job['expiry_date'] = date( 'Y-m-d H:i:s', strtotime( '+7 days' ) );

				$slugify = new Slugify();

				$existing_slugs = \Comfort\Job\Models\ComfortJob::query()->pluck( 'slug' )->toArray();
				$temp_slug      = $slugify->slugify( $job['title'] );
				$slug           = \Comfort\Job\Helpers\ComfortJobHelpers::generate_unique_slug( $temp_slug, $existing_slugs );

				$job['slug'] = $slug;

				\Comfort\Job\Models\ComfortJob::query()->create( $job );
			}
		}
		else{
			$i = 0;
		}

		$end = microtime( true );

		$elapsed = $end - $start;

		\WP_CLI::success( "Successfully $i dummy job added. Execution time: $elapsed seconds" );//todo: translation missing

	} //end method run
} //end class DummyJobGenerate
