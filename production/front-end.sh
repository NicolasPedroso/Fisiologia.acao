#!/bin/bash
# export NVM_DIR="/home/codespace/nvm"
# source $NVM_DIR/nvm.sh
export NVM_DIR="$HOME/.nvm"
[ -s "$(brew --prefix nvm)/nvm.sh" ] && \. "$(brew --prefix nvm)/nvm.sh"
[ -s "$(brew --prefix nvm)/etc/bash_completion.d/nvm" ] && \. "$(brew --prefix nvm)/etc/bash_completion.d/nvm"

LCT="../front-end"
LCTBCK="../back-end"
JSDB="./fakeApi.db.json"
BCK=1 # 1 para back-end real

nvm install --lts

# Setup JSON-SERVER
if [ $BCK -eq 0 ]; then
	npm install -g json-server
    json-server -w -p 8000 $JSDB &
    echo "Coloque a porta :8000 aberta"
else
	cd $LCTBCK
	composer install

	if ! test -f ".env"; then
		echo "Crie o arquivo .env seguindo o MARIADB"
		exit 1
	fi

	if ! docker start back;
	then
		echo "Inicie o docker"
		exit 1
	fi 

	php artisan key:generate
	php artisan migrate:fresh --seed
	php artisan passport:install
	php artisan passport:client --personal
	php artisan storage:link
	php artisan serve &
fi

# Setup front-end
cd $LCT
npm install
npm run lint:fix
npm run dev
