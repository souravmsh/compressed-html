# Compressed HTML
### A Laravel package for compressing HTML code

## USER MANUAL 
### STEPS:- 
1. Create packages directory at the root of the application 
2. Clone the Repository
3. Move souravmsh directory to packages directory
4. Add package repositories to application-root composer.json file
>     "repositories": [ 
>     	{
>     		"type": "path",
>     		"url": "./packages/souravmsh/compressed-html",
>     		"symlink": false
>     	} 
>     ]
6. install package via comopser
> composer require souravmsh/compressed-html
7. It will automatically add the package to your application
8. To enable/disable the package, add the below variable to the .env file
> COMPRESSED_HTML_EANBLE=true/false