#!/bin/sh

# find and deletes dead symlinks
cd /var/www/magento1810/htdocs && find -L . -type l -print0 | xargs -0 rm
lns -afFr /var/www/Mgt_CloudfrontInvalidation/htdocs/app/ /var/www/magento1810/htdocs/app
