# LaravelGenerators
Artisan command to generate MVC structure of app component

## Installation
Put the code above into composer ps-4 autoload:

```javascript
"psr-4": {
    "SafiStudio\\": "vendor/safistudio/generators/src/",
    "SafiStudio\\Console\\Commands\\": "vendor/safistudio/generators/commands/"
}
```

Put function above into post-install-cmd:

`
"\\SafiStudio\\Installer::warmCache"
`

