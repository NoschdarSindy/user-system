<?php
const
	UNAME = [
		'attr' => [
			'minlength' => 4,
			'maxlength' => 24,
			'pattern'   => '[-\w]+',
			'title'     => 'alphanumeric characters, underscores and hyphens',
			'required'  => true
		],
		'prop' => [
			'name'      => 'Username'
		]
	];