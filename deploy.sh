#!/bin/sh
rsync -avz ./ -e "ssh -p 5022"  ahqxqjrt@node48-eu.n0c.com:~/public_html/jacques-toupet.com --include=public/build --include=public/bundles --include=public/.htaccess --include=.htaccess --include=.env --exclude=vendor --exclude-from=.gitignore --exclude=".*" --exclude=".env.local" --exclude=deploy.sh
