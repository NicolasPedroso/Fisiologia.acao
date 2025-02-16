#!/bin/bash
export NVM_DIR="/home/codespace/nvm"
source $NVM_DIR/nvm.sh

LCT="../front-end"
JSDB="./fakeApi.db.json"
BCK=0 # 1 para back-end real

nvm install --lts
npm install -g json-server

# Setup JSON-SERVER
if [ $BCK -eq 0 ]; then
    json-server -w -p 8000 $JSDB &
    echo "Coloque a porta :8000 aberta"
fi

# Setup front-end
cd $LCT
npm install
npm run lint:fix
npm run dev