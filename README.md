<h1 align="center">
    🐧 Projeto base de back-end e front-end [2024]
</h1>

![Logo da Ecomp na frente de plantas](https://github.com/ecomp-co/.github/blob/main/assets/banner.png)

> "Projeto base da Ecomp, re-feito em 2024, com as tecnologias de Vue3, Nuxt e vuetify. Neste repositório também está junto o projeto base do Back-end. _**Observação**_: trocar essa descrição para a do projeto em vigor"

## ☕ Membros do Projeto

-   **PO**: 🐧
-   **SM**: 🐧
-   **Back-end**: 🐧
-   **Back-end**: 🐧
-   **Front-end**: 🐧
-   **Front-end**: 🐧

## 🐧 Documentos do Projeto

1. [Nome do MD com link local em docs/ARCHIVE.md]()

## 🚀 Infos do Projeto

1. [Kanban]()
2. [KPI]()
3. [Backlog]()
4. [Pasta do Projeto no acervo]()
5. [Layout]()

## 💻 Rodando o Front-end

Todos os comandos estão feitos para o Linux [Ubuntu]

1.  Trocando a **versão do NODE** - se necessário

    ```bash
    # Utilizando o 21, ou stable
    nvm install 21;
    nvm use 21;
    ```

2.  **Instalando** os pacotes do projeto. **Certifique** de estar na pasta do FRONT-END
    ```bash
    npm install;
    ```
3.  **Rodando** o projeto
    ```bash
    npm run dev;
    ```

## 🐝 Rodando o Back-end

Todos os comandos estão feitos para o Linux [Ubuntu]

### Método local

Necessário: php 7.4, docker & composer

1. Verificar a **versão atual do php** [7.4]
    ```bash
    php -v;
    ```
2. Iniciar o docker do mariaDB - importante trocar as informações deste script, como DB, user e password

    ```bash
    docker run --name back \
     -e MARIADB_RANDOM_ROOT_PASSWORD=yes \
     -e MARIADB_USER=seu_username \
     -e MARIADB_DATABASE=laravel \
     -e MARIADB_PASSWORD=sua_password \
     -p 3306:3306 \
     -d mariadb:10.10;
    ```

3. Iniciar o docker do back

    ```bash
    docker container start back;
    ```

4. Dentro da pasta do back-end: você precisa copiar o .env.example para um .env e configurar ele para ficar igual ao comando do MARIADB acima
    ```bash
    # Copiar o .env
    cp .env.example .env;
    # editar o .env
    vim .env;
    ```
5. Na pasta do back-end: instalar depedencias:
    ```bash
    composer install;
    ```
6. Na pasta do back-end: fazer migrates e links necessários:
    ```bash
    php artisan migrate:fresh --seed;
    php artisan key:generate;
    php artisan passport:install --force;
    php artisan passport:client --personal;
    php artisan storage:link;
    ```
7. Com tudo isso feito, você pode inciar o back-end na porta 8000 por este comando:
    ```bash
    php artisan serve;
    ```

### Método de containers

Veja este repositório: https://github.com/AllanSilva29/docker-laravel7-example

Mas se precisarem de ajuda, não hesitem de contatar **Projetos** ou **Qualita** :)

## **🖳 Fazendo PULL REQUESTS**

Tutorial para fazer o Pull Request para a diretoria de Qualidade

1. **Ir na aba de PULL REQUESTS**
   Base: develop
   compare: branch-para-ser-mergeada
2. **Colocar um titulo: "merge BRANCH-ALVO into DEVELOP"**
3. **Colocar uma descrição do que foi feito, adendos e falar sobre os conflitos de merge se aparecer**
4. **Clicar em Pull Request**
5. **Preencher o [FORMS do PIFEPY](https://app.pipefy.com/public/form/n7RAK_kl)**
    - Nome do dev
    - De qual projeto a issue se refere
    - Nome da issue a ser avaliada
    - Arquivo mostrando testes feitos na issue: print do postman e/ou print ou video da tela do site/app
    - descrição dos testes, o que eles mostram, o que foi feito, etc
    - comentários adicionais (opcional)
    - alguma observação, como conflito e etc.
6. **Esperar qualita avaliar**
    - se houver erro, qualita irá comentar no PR
    - se o dev corrigir algo na issue, comentar no PR com a tag [toqualita] descrevendo o que foi corrigido
