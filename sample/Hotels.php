<?php
// Form view
$form = [
    'title' => 'Formularz hotelu',
    'fields' => [
        [
            'label' => 'Tytuł',
            'name' => 'title',
            'type' => 'text',
            'params' => [
                'size' => 50,
                'maxlength' => 100,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Adres',
            'name' => 'address',
            'type' => 'text',
            'params' => [
                'size' => 150,
                'maxlength' => 100,
            ],
            'rules' => 'required',
        ],
        [
            'label' => 'Zdjęcie',
            'name' => 'image',
            'type' => 'file',
            'params' => [
                'size' => 150,
                'maxlength' => 100,
            ],
            'rules' => '',
        ],
        [
            'label' => 'Blisko wody',
            'name' => 'near_water',
            'type' => 'checkbox',
            'params' => [],
            'rules' => '',
        ],
        [
            'label' => 'Liczba pokoi',
            'name' => 'seats',
            'type' => 'select',
            'params' => [],
            'options' => [
                100 => '100',
                20000 => '2000 i więcej',
            ],
            'rules' => 'required',
        ],
    ],
];

// List view
$list = [
    'title' => 'Lista Hoteli',
    'headers' => ['Nazwa', 'Adres', 'Opis'],
    'columns' => [
        [
            'type' => 'text',
            'name' => 'title',
        ],
        [
            'type' => 'text',
            'name' => 'address',
        ],
        [
            'type' => 'text',
            'name' => 'description',
        ],
    ],
];