<?php

return [

	[
		'type' => 'item',
		'label' => _i("Brands"),
		'route' => "#",
		"icon" => "ti-menu-alt",
		'permission' => 'MasterMembership-Add',
		'links' => [
			[
				'label' => _i("All"),
				'route' => '/admin/brands',
				'action' => 'all',
				'permission' => 'MasterMembership-Add'
			],
			[
				'label' => _i("Add"),
				'route' => '/admin/brands/create',
				'action' => 'all',
				'permission' => 'MasterMembership-Add'
			],
		]
	],
	[
		'type' => 'item',
		'label' => _i("Currencies"),
		'route' => "#",
		"icon" => "ti-menu-alt",
		'permission' => 'MasterMembership-Add',
		'links' => [
			[
				'label' => _i("All"),
				'route' => '/admin/currencies',
				'action' => 'all',
				'permission' => 'MasterMembership-Add'
			],
			[
				'label' => _i("Add"),
				'route' => '/admin/currencies/create',
				'action' => 'all',
				'permission' => 'MasterMembership-Add'
			],
		]
	],
	[
		'type' => 'none',
		'label' => _i("Categories"),
		'route' => "admin/categories",
		"icon" => "ti-menu-alt",
		'permission' => 'MasterMembership-Add',
		'links' => []
	],
	[
		'type' => 'none',
		'label' => _i('Language'),
		'route' => 'admin/language',
		'permission' => 'MasterStore-Show',
		'icon' => 'ti-package',
		'links' => []
	],



];
