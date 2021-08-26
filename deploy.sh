#!/bin/sh
rsync -avz ./ -e "ssh -p 22"  admin@82.66.72.97:/var/www/html/site_toupet/ --include=public/build --include=public/bundles --include=public/.htaccess --include=vendor --exclude-from=.gitignore --exclude="public/images"
