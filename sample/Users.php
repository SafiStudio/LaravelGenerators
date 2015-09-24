<?php
// Queries
$sql = [
    // Create users table
    "CREATE TABLE IF NOT EXISTS `users` (
      `id` int(10) unsigned NOT NULL,
      `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
      `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
      `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
      `type` tinyint(1) NOT NULL DEFAULT '0',
      `active` tinyint(1) NOT NULL DEFAULT '0',
      PRIMARY KEY(id)
    )
    ",
    // Add default administrator
    "INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `type`, `active`)
    VALUES
    (1, 'Administrator', 'biuro@safistudio.pl', '$2y$10$3W76Y3yyN8iHQ1Vp8QMXD..WVGbSf2uE6sej3g4Nr/4C66.iYR.SS', 'h5oZinLGxSnJkX0EmKoqTczBIxFz8lavdfpAyzUfLcM1EzDYMfUxDd1QP17B', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 0, 1)
    ",
];

// Set controller extensions
$extensions = [

];

// Form view
$form = [
    'title' => 'Formularz użytkownika',
    'fields' => [
        [
            'label' => 'Imię i Nazwisko',
            'name' => 'name',
            'type' => 'text',
            'params' => [
                'size' => 50,
                'maxlength' => 200,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Adres e-mail',
            'name' => 'email',
            'type' => 'text',
            'params' => [
                'size' => 150,
                'maxlength' => 100,
            ],
            'rules' => 'email|unique:users,email|required',
        ],
        [
            'label' => 'Hasło',
            'name' => 'password',
            'type' => 'password',
            'params' => [
                'size' => 150,
                'maxlength' => 100,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Typ konta',
            'name' => 'type',
            'type' => 'select',
            'params' => [],
            'options' => [
                0 => 'Administrator',
                1 => 'Użytkownik',
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Konto aktywne',
            'name' => 'active',
            'type' => 'select',
            'params' => [],
            'options' => [
                0 => 'Nie',
                1 => 'Tak',
            ],
            'rules' => 'required',
        ],
    ],
];

// List view
$list = [
    'title' => 'Lista użytkowników',
    'headers' => ['Imię i Nazwisko', 'Adres e-mail', 'Typ konta'],
    'columns' => [
        [
            'type' => 'text',
            'name' => 'name',
        ],
        [
            'type' => 'text',
            'name' => 'email',
        ],
        [
            'type' => 'text',
            'name' => 'type',
        ],
    ],
];

// Searchable fields
$search = ['name', 'email'];