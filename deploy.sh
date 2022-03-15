#!/bin/sh
rsync -avz ./ -e "ssh -p 22"  admindev@82.66.72.97:/var/www/my_webapp/www/ --include=public/build --include=public/bundles --include=public/.htaccess --include=.htaccess --exclude-from=.gitignore --exclude="public/images"
