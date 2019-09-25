# Redwerk test

Project URL: http://redwerk.test

## Quickstart

1. Set correct settings for Homestead - in ```Homestead.yaml```
    - need set ```authorize:```
    - and ```keys:```
    - and fix path to project ```folders: -map```
    - Other setting can leave untouched.
2. Set DNS entry in ```hosts``` file - ```192.168.56.100 redwerk.test```
3. Start Vagrant by ```vagrant up``` -  and wait when virtual machine booted
4. Open project URL in browser ```http://redwerk.test```

## Database

Project used SQLite DB.

DB file placed on default location - ```database/database.sqlite```

## Project details

User image - can be set in "Profile".

Default user credentials:

- email: ```user@email.test```
- password: ```pass```