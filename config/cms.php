<?php

return [
	'templates' => [
    'Home' => App\Templates\HomeTemplate::class,
    'Somos' => App\Templates\SomosTemplate::class,
    'Avanzada' => App\Templates\AvanzadaTemplate::class,
    'Posteá tu oportunidad' => App\Templates\PosteaTemplate::class,
    'Contacto' => App\Templates\ContactoTemplate::class,
    'Términos y Condiciones' => App\Templates\TerminosTemplate::class,
    'Colaboradores' => App\Templates\ColaboradoresTemplate::class,
	],

  'constants' => [
    'title' => env('APP_NAME'),
    'vendor' => 'Kumanda',
    'url' => 'http://www.agenciakumanda.com'
  ],

	'options' => [
    1 => 'General',
    2 => 'Redes',
    3 => 'Meta'
	],

  'sexo' => [
    'Masculino' => 'Masculino',
    'Femenino'  => 'Femenino'
  ],
  
  'selectores' => [
    'temas' => 'Temas',
    'niveles'  => 'Niveles',
    'tiempo' => 'Tiempo',
    'financiamiento' => 'Financiamiento'
  ],

  'modalidad' => [
    1 => 'Presencial',
    2  => 'En línea'
  ],

  'types' => [
    1 => [
      'id' => 1,
      'name' => 'Páginas',
      'route' => 'pages',
      'table' => 'pages',
      'active' => 0
    ],
    2 => [
      'id' => 2,
      'name' => 'Blog',
      'route' => 'blog',
      'table' => 'posts',
      'active' => 1
    ],
    3 => [
      'id' => 3,
      'name' => 'Ofertas',
      'route' => 'ofertas',
      'table' => 'ofertas',
      'active' => 1
    ],
  ],
];