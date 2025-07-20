#!/bin/bash
export NVM_DIR="$HOME/.nvm"
[ -s "$(brew --prefix nvm)/nvm.sh" ] && \. "$(brew --prefix nvm)/nvm.sh"
[ -s "$(brew --prefix nvm)/etc/bash_completion.d/nvm" ] && \. "$(brew --prefix nvm)/etc/bash_completion.d/nvm"

LCT="../front-end"
LCTBCK="../back-end"

nvm install --lts

cd $LCTBCK
composer install

if ! test -f ".env"; then
    echo "Crie o arquivo .env seguindo o MARIADB"
    exit 1
fi

open /Applications/Docker.app
sleep 10;

docker start back;
sleep 5;

php artisan key:generate
php artisan migrate:fresh --seed
php artisan passport:install
php artisan passport:client --personal
php artisan storage:link
php artisan serve &

# Setup front-end
cd $LCT
npm install
npm run lint:fix
# npm run build
# npm run preview
npm run dev
