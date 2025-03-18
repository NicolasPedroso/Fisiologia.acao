#!/bin/bash

#
# Variáveis

# Seletor do tipo de instalação
declare -A install
install=( ['web']='true')

# Yes automático e diminui a saída pra facilitar o debug de erros
APT_FLAGS=" -y -qq "
MYSQL_AUTOCONFIG='true'

# Obtém o nome do sistema e sua versão
OS=$(lsb_release -i -s)
OS_VERSION=$(tail -n 1 /etc/os-release | cut -d= -f2-)
OS_RELEASE=$(lsb_release -r -s)

if [[ ${OS} -ne 'Ubuntu' ]]; then
    echo "Seu sistema não é suportado por esse script, por favor instale um que seja suportado"
    exit
fi

#
# Mensagem de ajuda
function help_msg () {
    version
    echo -e ""
    echo -e " Uso: sudo $0 <tipo de instalacao>"
    echo -e "\tTipo de instalação: um dentre [tudo, web, mobile]"
    echo
    echo -e " [Opções]: "
    echo -e "\t-h --help: Exibe esta mensagem de ajuda"
    echo -e "\t-v --version: Exibe a versão do script"
    echo -e "\t--check-install: Testa se os programas estão instalados"
    echo -e "\t--no-mysql-autoconfig: Não configura o MariaDB automaticamente"
    echo -e "\t--no-upgrade: Não atualiza os pacotes atuais antes de começar [TODO]"
}

#
# Busca por versões dos programas
function check-install () {
    programas=('php' 'npm' 'mysql' 'java' 'javac' 'adb')

    flag=false

    for cmd in "${programas[@]}"; do

        ${cmd} --version &> /dev/null
        if [ $? = 0 ]; then
            echo ">> Instalação do ${cmd} detectada"
            ${cmd} --version
            flag=true

        else
            echo "!! Instalação do ${cmd} não detectada !!"
        fi

        echo
    done

    if [ ${flag} == 'true' ]; then
        echo "Existem alguns programas instalados que precisam ser reinstalados por esse script, remova-os antes de continuar"
        exit
    fi
}

#
# Função para padronizar a saida de alguma informação
function info() {
    echo
    echo ">>> ${1} ..."
    echo
}

function version() {
     echo "Script de Instalação Básica V1.3 - Ecomp"
     echo "2020~2021 - Wendel Moro, Victor Alflen e Rogério Bayer"
}

#
# Busca por opções de command line
for var in "$@"
do
    # Seção de ajuda
    if [[ ${var} = "-h" ]] || [[ ${var} = "--help" ]]; then
        help_msg
        exit
    fi

    if [[ ${var} = "-v" ]] || [[ ${var} = "--version" ]]; then
        version
        exit
    fi

    if [[ ${var} = "--check-install" ]]; then
        check-install
        exit
    fi

    if [[ ${var} = "--no-mysql-autoconfig" ]]; then
        MYSQL_AUTOCONFIG='false'
    fi

done

if [ "$EUID" -ne 0 ]; then
    echo "Por favor, execute como root."
    echo
    exit
fi

#
version
echo
echo "Iniciando instalação"
echo "Isso VAI demorar um pouco..."
echo "Aproveite para tomar um café!"
echo
#

#if [ ! -e /usr/bin/snap ]; then
#    echo 'export PATH=$PATH:/snap/bin' >> ~/.bashrc
#fi

info "Atualizando o seu sistema"

#
# Atualização básica
apt-get ${APT_FLAGS} update && apt-get ${APT_FLAGS} upgrade

info "Instalando pacotes básicos e dependencias"

# Pacotes básicos
#apt-get install ${APT_FLAGS} software-properties-common git curl wget zip unzip snapd > /dev/null
apt-get install ${APT_FLAGS} software-properties-common git curl wget zip unzip gpg> /dev/null

#info "Instalando editores de texto (gedit, vim, nano)"
# Editores básicos:
#apt-get install ${APT_FLAGS} gedit vim nano > /dev/null

#info "Instalando monitores de desempenho (htop, glances)"
# Visualização de dados do PC
#apt-get install ${APT_FLAGS} htop glances > /dev/null

#
# Web
if [ ${install["web"]} = 'true' ]; then

    #
    # Instala Nodejs 16.0
    tput setaf 2; info "Instalação do Front"; tput sgr0;
    . ~/.nvm/nvm.sh
    . ~/.profile
    . ~/.bashrc
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash
    export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm
    export NVM_DIR=$HOME/.nvm;
    source $NVM_DIR/nvm.sh;
    nvm install v21.*;
    nvm use 21.*;
    nvm alias default v21.*;


    #
    # Instala PHP
    tput setaf 2; info "Instalação do Back"; tput sgr0;

    info "Instalando repositório do php"
    add-apt-repository -y ppa:ondrej/php > /dev/null
    apt-get update > /dev/null

    info "Instalando php 8.3"
    apt-get install ${APT_FLAGS} php8.3 > /dev/null
    apt-get install ${APT_FLAGS} php8.3-cli php8.3-{bz2,curl,mbstring,intl,common,pdo,fpm,mysql,opcache,bcmath,mbstring,tokenizer,xml,zip,soap} -y > /dev/null

    # Composer
    info "Instalando composer"
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer > /dev/null

    #
    # Instala Postman
    info "Instalando Postman"

    wget https://dl.pstmn.io/download/latest/linux64 -O postman.tar.gz;
    tar -xzf postman.tar.gz;
    rm -rf /opt/Postman;
    mv Postman /opt;
    ln -s /opt/Postman/Postman /usr/local/bin/postman;
    touch /usr/share/applications/postman.desktop;
    echo '[Desktop Entry]' >> /usr/share/applications/postman.desktop;
    echo 'Type=Application' >> /usr/share/applications/postman.desktop;
    echo 'Name=Postman' >> /usr/share/applications/postman.desktop;
    echo 'Icon=/opt/Postman/app/resources/app/assets/icon.png' >> /usr/share/applications/postman.desktop;
    echo 'Exec="/opt/Postman/Postman"' >> /usr/share/applications/postman.desktop;
    echo 'Comment=Postman GUI' >> /usr/share/applications/postman.desktop;
    echo 'Categories=Development;Code;' >> /usr/share/applications/postman.desktop;
    rm postman.tar.gz;

    #
    # Instala MariaDB
    info "Instalando Repositório do Mariadb";
    curl -LsS https://r.mariadb.com/downloads/mariadb_repo_setup | sudo bash -s -- --os-type=ubuntu --os-version=$OS_VERSION;
    info "Instalando Mariadb mais recente";
    apt update && apt install ${APT_FLAGS} mariadb-server mariadb-client
fi


#
# Utilidades
if [[ ${MYSQL_AUTOCONFIG} -eq 'true' ]]; then

    #
    # Cria o usuário ecomp com a senha 'ecompirinha'
    echo "CREATE USER 'ecomp'@'localhost' IDENTIFIED BY 'ecompirinha';" > tmp.sql
    echo "CREATE DATABASE ecomper;" >> tmp.sql
    echo "GRANT ALL PRIVILEGES ON *.* TO 'ecomp'@'localhost';" >> tmp.sql
    echo "FLUSH PRIVILEGES;" >> tmp.sql
    mariadb -u root < tmp.sql;
    rm tmp.sql

    service mariadb restart

    echo "Seu usuário MYSQL: ecomp"
    echo "Sua senha MYSQL: ecompirinha"

fi
