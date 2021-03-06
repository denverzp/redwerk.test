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
4. (Optional) Re-Install project dependencies:
   - logged in Vagrant - ```vagrant ssh```
   - ```cd code/```
   - ```composer install```
5. Check link ```public/storage``` - if this link dont work - need recreate it:
    - logged in Vagrant - ```vagrant ssh```
    - ```cd code/```
    - ```rm public/storage```
    - ```php artisan storage:link```
6. Open project URL in browser ```http://redwerk.test```

## Project details

Default user credentials:

- email: ```user@email.test```
- password: ```pass```

User image - can be set in "Profile", after authorization.

Add. update and delete adverts - allow only after authorization.

## Database

Project use SQLite DB.

DB file placed on default location - ```database/database.sqlite```

## Frontend

Frontend based on Vue.js - and not need to rebuilded.