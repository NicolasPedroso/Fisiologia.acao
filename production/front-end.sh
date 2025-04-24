#!/bin/bash
// export NVM_DIR="/home/codespace/nvm"
// source $NVM_DIR/nvm.sh
export NVM_DIR="$HOME/.nvm"
[ -s "$(brew --prefix nvm)/nvm.sh" ] && \. "$(brew --prefix nvm)/nvm.sh"
[ -s "$(brew --prefix nvm)/etc/bash_completion.d/nvm" ] && \. "$(brew --prefix nvm)/etc/bash_completion.d/nvm"

LCT="../front-end"
JSDB="./fakeApi.db.json"
BCK=1 # 1 para back-end real

nvm install --lts
npm install -g json-server

# Setup JSON-SERVER
if [ $BCK -eq 0 ]; then
    json-server -w -p 8000 $JSDB &
    echo "Coloque a porta :8000 aberta"
else
	cd ../back-end
	composer install
	echo "Verifique o .env e docker aberto"	

	docker start back;
	php artisan key:generate;
	php artisan migrate:fresh --seed;
	php artisan passport:install;
	php artisan passport:client --personal;
	php artisan storage:link;
	php artisan serve &	
fi

# Setup front-end
cd $LCT
npm install
npm run lint:fix
npm run dev
