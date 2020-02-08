<?php
const
	PWORD = [
		'attr' => [
			'minlength' => 6,
			'maxlength' => 100,
			'pattern'   => '[\S]+',
			'title'     => 'non-whitespace characters',
			'required'  => true
		],
		'prop' => [
			'name'      => 'Password'
		]
	];