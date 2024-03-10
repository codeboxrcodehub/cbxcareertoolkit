<?php

namespace Cbx\Careertoolkit\Factories\Job;

use Cbx\Careertoolkit\Factories\Factory;
use Faker\Factory as FakerFactory;

/**
 * Dummy job data generate command
 * Class DummyJobGenerate
 * @since 1.0.0
 */
class DummyJobGenerate extends Factory
{

	/**
	 * Register CLI command
	 * @since 1.0.0
	 */
	public function wp_cli_register_commands()
	{
		\WP_CLI::add_command('cbxjob-generate', [$this, "run"]);
	} //end method wp_cli_register_commands

	/**
	 * Command activity
	 *
	 * @param $args
	 * @param $assoc_args
	 *
	 * @since 1.0.0
	 */
	public function run($args, $assoc_args)
	{
		$start = microtime(true);

		$total = isset($assoc_args['total']) && intval($assoc_args['total']) ? intval($assoc_args['total']) : 100;
		$status = isset($assoc_args['status']) ? sanitize_text_field($assoc_args['status']) : 'publish';
		$is_remote = isset($assoc_args['is-remote']) && intval($assoc_args['is-remote']) ? intval($assoc_args['is-remote']) : 0;
		$is_featured = isset($assoc_args['is-featured']) && intval($assoc_args['is-featured']) ? intval($assoc_args['is-featured']) : 1;
		$is_filled = isset($assoc_args['is-filled']) && intval($assoc_args['is-filled']) ? intval($assoc_args['is-filled']) : 0;

		$salary_currency = isset($assoc_args['currency']) ? sanitize_text_field($assoc_args['currency']) : 'USD';
		$salary_unit = isset($assoc_args['salary-unit']) ? sanitize_text_field($assoc_args['salary-unit']) : 'monthly';

		$user_id = isset($assoc_args['user-id']) && intval($assoc_args['user-id']) ? intval($assoc_args['user-id']) : 1;

		for ($i = 0; $i < $total; $i++) {

			$user_data = get_userdata($user_id);

			$cbxjob['add_by'] = $user_id; //user id = X
			$cbxjob['add_date'] = date('Y-m-d H:i:s');
			//$cbxjob['email'] = FakerFactory::create()->email();
			$cbxjob['email'] = $user_data->user_email;
			$cbxjob['title'] = FakerFactory::create()->jobTitle();
			$cbxjob['status'] = $status;
			$cbxjob['job_location'] = FakerFactory::create()->address();
			$cbxjob['is_featured'] = $is_featured;
			$cbxjob['is_filled'] = $is_filled;
			$cbxjob['salary_amount'] = FakerFactory::create()->randomNumber(3);
			$cbxjob['is_remote'] = $is_remote;
			$cbxjob['application_url'] = FakerFactory::create()->url();
			$cbxjob['description'] = FakerFactory::create()->text();
			$cbxjob['open_positions'] = FakerFactory::create()->randomNumber(1);

			$cbxjob['misc'] = [
				'salary_currency' => $salary_currency,
				'job_location' => FakerFactory::create()->address(),
				'company_name' => FakerFactory::create()->company(),
				'salary_unit' => $salary_unit,
				'company_website' => FakerFactory::create()->url(),
				'company_logo' => '',
				'company_logo_source' => 'job',
				'company_logo_url' => FakerFactory::create()->imageUrl(360, 360, 'company', true),
			];


			//$cbxjob['mod_by'] = $job->post_author;
			$cbxjob['mod_date'] = date('Y-m-d H:i:s');

			$cbxjob['closing_date'] = date('Y-m-d H:i:s', strtotime('+7 days'));

			$cbxjob['expiry_date'] = date('Y-m-d H:i:s', strtotime('+7 days'));



			\Cbx\Job\Models\CBXJob::query()->create($cbxjob);
		}
		$end = microtime(true);

		$elapsed = $end - $start;

		\WP_CLI::success("Successfully $total dummy job added. Execution time $elapsed seconds");

	} //end method run
} //end class DummyJobGenerate
