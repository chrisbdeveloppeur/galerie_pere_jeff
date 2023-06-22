#!/bin/sh
rsync -avz ./ -e "ssh -p 5022"  ahqxqjrt@node48-eu.n0c.com:~/public_html/jacques-toupet --include=public/build --include=public/bundles --include=public/.htaccess --include=.htaccess --include=.env --exclude=".env.local" --exclude=deploy.sh
