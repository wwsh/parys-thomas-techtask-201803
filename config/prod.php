<?php

// configure your app for the production environment

use TechTask\Model\Recipe;

$app['twig.path']    = [__DIR__ . '/../templates'];
$app['twig.options'] = ['cache' => __DIR__ . '/../var/cache/twig'];

$databasePath = __DIR__ . '/../database/';

// global resource repository

$app['database.resources'] = [
    'recipes'     => [
        'type'     => 'json',
        'resource' => $databasePath . 'recipes.json',
        'options'  => [
            'json.starting_property' => 'recipes'
        ]
    ],
    'ingredients' => [
        'type'     => 'json',
        'resource' => $databasePath . 'ingredients.json',
        'options'  => [
            'json.starting_property' => 'ingredients'
        ]
    ]
];

// database driver

$app['database.driver'] = new \TechTask\Database\Driver\JSON();

// database mapper class

$app['database.mapper.class'] = Recipe::class;

// which resources to load where

$app['database.facade.resource'] = 'recipes';
$app['database.recipe_processor.resource'] = 'ingredients';
