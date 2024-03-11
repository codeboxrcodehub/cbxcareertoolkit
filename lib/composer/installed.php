<?php return [
	'root'     => [
		'name'           => 'cbx/dev-toolkit',
		'pretty_version' => 'dev-dev',
		'version'        => 'dev-dev',
		'reference'      => '14c5a0f0fcb4beac5a0400b90cbb8ab2b3ea072a',
		'type'           => 'library',
		'install_path'   => __DIR__ . '/../../',
		'aliases'        => [],
		'dev'            => true,
	],
	'versions' => [
		'cbx/dev-toolkit'               => [
			'pretty_version'  => 'dev-dev',
			'version'         => 'dev-dev',
			'reference'       => '14c5a0f0fcb4beac5a0400b90cbb8ab2b3ea072a',
			'type'            => 'library',
			'install_path'    => __DIR__ . '/../../',
			'aliases'         => [],
			'dev_requirement' => false,
		],
		'fakerphp/faker'                => [
			'pretty_version'  => 'v1.23.0',
			'version'         => '1.23.0.0',
			'reference'       => 'e3daa170d00fde61ea7719ef47bb09bb8f1d9b01',
			'type'            => 'library',
			'install_path'    => __DIR__ . '/../fakerphp/faker',
			'aliases'         => [],
			'dev_requirement' => false,
		],
		'psr/container'                 => [
			'pretty_version'  => '2.0.2',
			'version'         => '2.0.2.0',
			'reference'       => 'c71ecc56dfe541dbd90c5360474fbc405f8d5963',
			'type'            => 'library',
			'install_path'    => __DIR__ . '/../psr/container',
			'aliases'         => [],
			'dev_requirement' => false,
		],
		'symfony/deprecation-contracts' => [
			'pretty_version'  => 'v2.5.2',
			'version'         => '2.5.2.0',
			'reference'       => 'e8b495ea28c1d97b5e0c121748d6f9b53d075c66',
			'type'            => 'library',
			'install_path'    => __DIR__ . '/../symfony/deprecation-contracts',
			'aliases'         => [],
			'dev_requirement' => false,
		],
	],
];
