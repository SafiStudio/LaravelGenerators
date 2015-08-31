<?php
$sql = "
    CREATE TABLE IF NOT EXISTS hotels(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NULL,
    `description` TEXT NOT NULL,
    `city` VARCHAR(100) NOT NULL,
    `post_code` VARCHAR(6) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `create_date` DATETIME NOT NULL,
    PRIMARY KEY(id)
    );
";
// Form view
$form = [
    'title' => 'Formularz Hotelu',
    'fields' => [
        [
            'label' => 'Tytuł',
            'name' => 'title',
            'type' => 'text',
            'params' => [
                'size' => 150,
                'maxlength' => 255,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Miasto',
            'name' => 'city',
            'type' => 'text',
            'params' => [
                'size' => 150,
                'maxlength' => 100,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Kod pocztowy',
            'name' => 'post_code',
            'type' => 'text',
            'params' => [
                'size' => 150,
                'maxlength' => 6,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Adres',
            'name' => 'address',
            'type' => 'text',
            'params' => [
                'size' => 150,
                'maxlength' => 255,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Opis',
            'name' => 'description',
            'type' => 'editor',
            'params' => [
            ],
            'rules' => 'required',
        ],
    ],
];

// List view
$list = [
    'title' => 'Lista Hoteli',
    'headers' => ['Tytuł', 'Miasto', 'Adres'],
    'columns' => [
        [
            'type' => 'text',
            'name' => 'title',
        ],
        [
            'type' => 'text',
            'name' => 'city',
        ],
        [
            'type' => 'text',
            'name' => 'address',
        ],
    ],
];

// Searchable fields
$search = ['title','city','address','description'];