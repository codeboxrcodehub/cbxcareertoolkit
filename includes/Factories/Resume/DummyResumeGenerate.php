<?php

namespace Cbx\Careertoolkit\Factories\Resume;

use Ramsey\Uuid\Uuid;
use Cbx\Careertoolkit\Factories\Factory;
use Faker\Factory as FakerFactory;
use WP_User_Query;

/**
 * Dummy resume data generate command
 * Class DummyResumeGenerate
 * @since 1.0.0
 */
class DummyResumeGenerate extends Factory {

	/**
	 * Register CLI command
	 * @since 1.0.0
	 */
	public function wp_cli_register_commands() {
		\WP_CLI::add_command( 'comfortresume-generate', [ $this, "run" ] );
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

		$total     = isset( $assoc_args['total'] ) && intval( $assoc_args['total'] ) ? intval( $assoc_args['total'] ) : 100;
		$user_id   = isset( $assoc_args['user-id'] ) && intval( $assoc_args['user-id'] ) ? intval( $assoc_args['user-id'] ) : 0;
		$status    = isset( $assoc_args['status'] ) && intval( $assoc_args['status'] ) ? intval( $assoc_args['status'] ) : 'published';
		$privacy   = isset( $assoc_args['privacy'] ) && strval( $assoc_args['privacy'] ) ? strval( $assoc_args['privacy'] ) : "public";
		$isPrimary = isset( $assoc_args['is-primary'] ) && intval( $assoc_args['is-primary'] ) ? intval( $assoc_args['is-primary'] ) : 0;

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

			// Check if any users are found and output the first user's ID
			if ( ! empty( $users ) ) {
				$user_id = $users[0]->ID;

			}
		}



		if($user_id > 0){
			for ( $i = 0; $i < $total; $i ++ ) {
				$resume = [
					'add_by'     => $user_id,
					'owner'      => $user_id,
					'privacy'    => $privacy,
					'status'     => $status,
					'resume'     => json_encode( [
						(object) $this->aboutMe(),
						(object) $this->avatar(),
						(object) $this->education(),
						(object) $this->experience(),
						(object) $this->skills(),
						(object) $this->course(),
						(object) $this->license(),
						(object) $this->language(),
						(object) $this->website(),
						(object) $this->project(),
						(object) $this->honor(),
						(object) $this->publication(),
						(object) $this->patent(),
						(object) $this->hobby(),
						(object) $this->volunteer(),
					] ),
					'is_primary' => $isPrimary,
					'add_date'   => date( 'Y-m-d H:i:s' )
				];


				$slug = Uuid::uuid4();;

				$resume['slug'] = $slug;
				$resume['uuid'] = $slug;

				\Comfort\Resume\Models\Resume::query()->create( $resume );
			}
		}
		else{
			$i = 0;
		}



		$end = microtime( true );

		$elapsed = $end - $start;


		\WP_CLI::success( "Successfully $i dummy resume(s) added. Execution time: $elapsed seconds" );

	} //end method run

	/**
	 * aboutMe fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function aboutMe() {
		return [
			"key"   => "aboutme",
			"type"  => "aboutme",
			"value" => [
				(object) [
					"new"             => true,
					"given_name"      => FakerFactory::create()->name(),
					"family_name"     => FakerFactory::create()->lastName(),
					"headline"        => FakerFactory::create()->jobTitle(),
					"email"           => FakerFactory::create()->email(),
					"phonePreFix"     => "+880",
					"phone"           => FakerFactory::create()->phoneNumber(),
					"address_1"       => FakerFactory::create()->address(), //todo: street_address()
					"address_2"       => FakerFactory::create()->address(), //city().' - '.postcode()
					"about"           => FakerFactory::create()->realText( 300, 2 ),
					"profile_pic_url" => FakerFactory::create()->imageUrl( 360, 360, 'animals', true ),
					"profile_pic"     => "",
				]
			],
			"fixed" => true
		];
	} //end method aboutMe

	/**
	 * avatar fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function avatar() {
		return [
			"key"   => "avatar",
			"type"  => "avatar",
			"value" => [
				(object) [
					"pic"     => "",
					"pic_url" => FakerFactory::create()->imageUrl( 360, 360, 'animals', true ),
				]
			],
			"fixed" => true,
		];
	} //end method avatar

	/**
	 * education fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function education() {
		return [
			"key"   => "education",
			"type"  => "education",
			"value" => [
				(object) [
					"organization"   => FakerFactory::create()->company(),
					"degreeName"     => "Secondary School Certificate",
					"fieldsOfStudy"  => "Science",
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"grade"          => "5.00",
					"activities"     => "Programming, Games",
					"notes"          => FakerFactory::create()->text(),
				],
				(object) [
					"organization"   => FakerFactory::create()->company(),
					"degreeName"     => "Diploma In Computer Technology",
					"fieldsOfStudy"  => "CMT",
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"grade"          => "3.84",
					"activities"     => "Programming, Games",
					"notes"          => FakerFactory::create()->text(),
				],
				(object) [
					"organization"   => FakerFactory::create()->company(),
					"degreeName"     => "Bachelors",
					"fieldsOfStudy"  => "CSE",
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"grade"          => "3.84",
					"activities"     => "Programming, Games",
					"notes"          => FakerFactory::create()->text(),
				],
			],
		];
	} //end method education

	/**
	 * experience fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function experience() {
		return [
			"key"   => "experience",
			"type"  => "experience",
			"value" => [
				(object) [
					"title"          => FakerFactory::create()->jobTitle(),
					"company"        => FakerFactory::create()->company(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
					"location"       => FakerFactory::create()->address(),
				],
				(object) [
					"title"          => FakerFactory::create()->jobTitle(),
					"company"        => FakerFactory::create()->company(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
					"location"       => FakerFactory::create()->address(),
				],
				(object) [
					"title"          => FakerFactory::create()->jobTitle(),
					"company"        => FakerFactory::create()->company(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
					"location"       => FakerFactory::create()->address(),
				]
			]
		];
	} //end method experience

	/**
	 * skills fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function skills() {
		return [
			"key"   => "skill",
			"type"  => "skill",
			"value" => [
				(object) [
					"name"  => FakerFactory::create()->name(),
					"score" => FakerFactory::create()->randomDigit()
				],
				(object) [
					"name"  => FakerFactory::create()->name(),
					"score" => FakerFactory::create()->randomDigit()
				],
				(object) [
					"name"  => FakerFactory::create()->name(),
					"score" => FakerFactory::create()->randomDigit()
				],
				(object) [
					"name"  => FakerFactory::create()->name(),
					"score" => FakerFactory::create()->randomDigit()
				],
				(object) [
					"name"  => FakerFactory::create()->name(),
					"score" => FakerFactory::create()->randomDigit()
				],
				(object) [
					"name"  => FakerFactory::create()->name(),
					"score" => FakerFactory::create()->randomDigit()
				]
			],
		];
	} //end method skills

	/**
	 * course fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function course() {
		return [
			"key"   => "course",
			"type"  => "course",
			"value" => [
				(object) [
					"name"                   => FakerFactory::create()->name(),
					"number"                 => FakerFactory::create()->randomNumber( 2 ),
					"associated_with_others" => "WP - " . FakerFactory::create()->randomNumber( 2 ),
				],
				(object) [
					"name"                   => FakerFactory::create()->name(),
					"number"                 => FakerFactory::create()->randomNumber( 2 ),
					"associated_with_others" => "WP - " . FakerFactory::create()->randomNumber( 2 ),
				],
				(object) [
					"name"                   => FakerFactory::create()->name(),
					"number"                 => FakerFactory::create()->randomNumber( 2 ),
					"associated_with_others" => "WP - " . FakerFactory::create()->randomNumber( 2 ),
				],
				(object) [
					"name"                   => FakerFactory::create()->name(),
					"number"                 => FakerFactory::create()->randomNumber( 2 ),
					"associated_with_others" => "WP - " . FakerFactory::create()->randomNumber( 2 ),
				]
			]
		];
	} //end method course

	/**
	 * license fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function license() {
		return [
			"key"   => "license",
			"type"  => "license",
			"value" => [
				(object) [
					"name"           => FakerFactory::create()->name(),
					"company"        => FakerFactory::create()->company(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"licenseNumber"  => "349U2-TUT4H-6HGGJ-2CHUK",
					"url"            => FakerFactory::create()->url(),
				],
				(object) [
					"name"           => FakerFactory::create()->name(),
					"company"        => FakerFactory::create()->company(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"licenseNumber"  => "349U2-TUT4H-6HGGJ-2CHUK",
					"url"            => FakerFactory::create()->url(),
				]
			]
		];
	} //end method license

	/**
	 * language fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function language() {
		return [
			"key"   => "language",
			"type"  => "language",
			"value" => [
				(object) [
					"name"        => "Bangla",
					"proficiency" => "Native or bilingual proficiency"
				],
				(object) [
					"name"        => "English",
					"proficiency" => "Native or bilingual proficiency"
				]
			]
		];
	} //end method language

	/**
	 * website fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function website() {
		return [
			"key"   => "website",
			"type"  => "website",
			"value" => [
				(object) [
					"category" => "PERSONAL",
					"label"    => "Git",
					"url"      => FakerFactory::create()->url(),
				],
				(object) [
					"category" => "COMPANY",
					"label"    => FakerFactory::create()->company(),
					"url"      => FakerFactory::create()->url(),
				],
				(object) [
					"category" => "SOCIAL",
					"label"    => "Twitter",
					"url"      => FakerFactory::create()->url(),
				],
				(object) [
					"category" => "SOCIAL",
					"label"    => "Facebook",
					"url"      => FakerFactory::create()->url(),
				]
			]
		];
	} //end method website

	/**
	 * project fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function project() {
		return [
			"key"   => "project",
			"type"  => "project",
			"value" => [
				(object) [
					"title"          => FakerFactory::create()->name(),
					"url"            => FakerFactory::create()->url(),
					"members"        => implode( ",", [
						FakerFactory::create()->name(),
						FakerFactory::create()->name(),
						FakerFactory::create()->name()
					] ),
					"occupation"     => FakerFactory::create()->jobTitle(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
				],
				(object) [
					"title"          => FakerFactory::create()->name(),
					"url"            => FakerFactory::create()->url(),
					"members"        => implode( ",", [
						FakerFactory::create()->name(),
						FakerFactory::create()->name(),
						FakerFactory::create()->name()
					] ),
					"occupation"     => FakerFactory::create()->jobTitle(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
				],
				(object) [
					"title"          => FakerFactory::create()->name(),
					"url"            => FakerFactory::create()->url(),
					"members"        => implode( ",", [
						FakerFactory::create()->name(),
						FakerFactory::create()->name(),
						FakerFactory::create()->name()
					] ),
					"occupation"     => FakerFactory::create()->jobTitle(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
				],
				(object) [
					"title"          => FakerFactory::create()->name(),
					"url"            => FakerFactory::create()->url(),
					"members"        => implode( ",", [
						FakerFactory::create()->name(),
						FakerFactory::create()->name(),
						FakerFactory::create()->name()
					] ),
					"occupation"     => FakerFactory::create()->jobTitle(),
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 300 ),
				]
			]
		];
	} //end method project

	/**
	 * honor fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function honor() {
		return [
			"key"   => "honor",
			"type"  => "honor",
			"value" => [
				(object) [
					'title'       => FakerFactory::create()->title(),
					'occupation'  => FakerFactory::create()->jobTitle(),
					'issuer'      => FakerFactory::create()->company(),
					'issueDate'   => FakerFactory::create()->date( "m-Y" ),
					'description' => FakerFactory::create()->text( 150 ),
				],
				(object) [
					'title'       => FakerFactory::create()->title(),
					'occupation'  => FakerFactory::create()->jobTitle(),
					'issuer'      => FakerFactory::create()->company(),
					'issueDate'   => FakerFactory::create()->date( "m-Y" ),
					'description' => FakerFactory::create()->text( 150 ),
				],
			],
		];
	} //end method honor

	/**
	 * publication fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function publication() {
		return [
			"key"   => "publication",
			"type"  => "publication",
			"value" => [
				(object) [
					"name"        => FakerFactory::create()->name(),
					"publisher"   => "Rokomary",
					"date"        => FakerFactory::create()->date( "m-Y" ),
					"authors"     => FakerFactory::create()->name(),
					"url"         => FakerFactory::create()->url(),
					"description" => FakerFactory::create()->text( 100 ),
				]
			]
		];
	} //end method publication

	/**
	 * patent fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function patent() {
		return [
			"key"   => "patent",
			"type"  => "patent",
			"value" => [
				(object) [
					"title"             => "Electric Light Bulb",
					"applicationNumber" => "US223898A",
					"inventors"         => FakerFactory::create()->name(),
					"pending"           => "issued",
					"issueDate"         => "",
					"filingDate"        => "2022-09-06T03:47:00.000Z",
					"url"               => FakerFactory::create()->url(),
					"description"       => FakerFactory::create()->text( 100 ),
					"startMonthYear"    => "2023-01-19T12:42:00.000Z",
				]
			]
		];
	} //end method patent

	/**
	 * hobby fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function hobby() {
		return [
			"key"   => "hobby",
			"type"  => "hobby",
			"value" => [
				(object) [
					"name" => FakerFactory::create()->name()
				],
				(object) [
					"name" => FakerFactory::create()->name()
				],
				(object) [
					"name" => FakerFactory::create()->name()
				],
				(object) [
					"name" => FakerFactory::create()->name()
				],
			]
		];
	} //end method hobby

	/**
	 * volunteer fake data generate
	 *
	 * @return array
	 * @since 1.0.0
	 */
	private function volunteer() {
		return [
			"key"   => "volunteer",
			"type"  => "volunteer",
			"value" => [
				(object) [
					"companyName"    => FakerFactory::create()->company(),
					"role"           => FakerFactory::create()->jobTitle(),
					"cause"          => "Children",
					"startMonthYear" => FakerFactory::create()->date( "m-Y" ),
					"endMonthYear"   => FakerFactory::create()->date( "m-Y" ),
					"description"    => FakerFactory::create()->text( 150 ),
				]
			]
		];
	} //end method volunteer


} //end class DummyResumeGenerate
