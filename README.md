# LaravelGenerators
Artisan command to generate MVC structure of app component

## Installation
Add new require to composer file:

`
"safistudio/generators": "@dev"
`

Add new repository to composer file:

```javascript
{
    "type": "vcs",
    "url": "https://github.com/SafiStudio/LaravelGenerators"
}
```

Add the code below in composer ps-4 autoload block:

```javascript
"psr-4": {
    "SafiStudio\\": "vendor/safistudio/generators/src/",
    "SafiStudio\\Console\\Commands\\": "vendor/safistudio/generators/commands/"
}
```

Add post-install function in composer as below:

`
"\\SafiStudio\\Installer::warmCache"
`

Add post-update function in composer as below:

`
"\\SafiStudio\\Installer::postUpdate"
`

## Usage

`
php artisan generator:package {PackageName}
`

where {PackageName} is the name of app component.