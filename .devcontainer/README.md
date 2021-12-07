# VSCODE Dev Containers

## Setup

1. Install VS Code Remote Dev [Extension](https://aka.ms/vscode-remote/download/extension)
2. Open Command Palette (F1) and select *Remote-Containers: Open Folder in Container...*
3. Wait for all containers to start
4. Copy sample `.env.sample` file and use option 2
```bash
$ cp .env.example .env
```
5. Install dependencies
```
# Composer
$ composer install

# Yarn
$ yarn

# DB migrations & Seeder
$ ./artisan migrate:fresh --seed
```

6. To run your dev you will need to start each of following in separate terminal tab
```bash
# bash 1 terminal - Laravel API 
yarn api

# bash 2 terminal - Nuxt Server
yarn dev
```

## XDEBUG
Current app container comes installed with php xdebug setup. 
To use it you will need to make sure your vscode .vscode/launch.json is setup
```json
{
    "version": "0.2.0",
    "configurations": [
      {
        "name": "Listen for Xdebug",
        "type": "php",
        "request": "launch",
        "port": 9003
      }
    ]
}
```
To start debugging make sure you start the VSCODE debugger (Listen for Xdebug) before starting `yarn api`
