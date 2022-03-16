#!/bin/sh
rsync -avz ./ -e "ssh -p 22"  admindev@82.66.72.97:/var/www/my_webapp/www/ --include=public/build --include=public/bundles --include="public/.htaccess" --include=vendor --exclude="public/images" --exclude=.gitignore --exclude="/.env.local" --exclude="Putty - Web Toupet.Ink"
