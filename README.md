# TMS (Tampere Multisite) WordPress Plugin Network Site List

WordPress plugin for that provides a REST endpoint for listing all sites in a network installation.

## Prerequisites

* WordPress Network installation

## Routes

Route `/wp-json/tms/sites/` returns site list as an array.
````
[
	[
		'ID' => 1,
		'name' => 'foo',
	],
	[
		'ID' => 2,
		'name' => 'bar',
	],
	[
		'ID' => 3,
		'name' => 'baz',
	],
]
````

## Contributing

Contributions are highly welcome! Just leave a pull request of your awesome well-written must-have feature.
