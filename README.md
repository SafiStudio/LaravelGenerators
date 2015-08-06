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

Add post-update function in composer as below:

```javascript
"post-update-cmd": [
    "php artisan optimize",
    "\\SafiStudio\\Installer::postUpdate"
],
```

Run composer update


Add new auth middleware in Kernel middlewares

`
'auth.admin' => 'APP_NAMESPACE\Http\Middleware\Admin\Authenticate::class'
`

Add new command in Kernel commands

`
\SafiStudio\Console\Commands\Generator::class
`

## Usage

`
php artisan generator:package {PackageName}
`

where {PackageName} is the name of app component.

### Before component generate

Check app/Generators/Hotels.php file to check how generator's description looks like