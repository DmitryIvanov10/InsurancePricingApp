# InsurancePricingApp
A test task to check insurance price

## Versions:
**Symfony 4.4**

**PHP 7.4.6**

**MySQL 5.7**

## Install and run:
1. ```git clone git@github.com:DmitryIvanov10/InsurancePricingApp.git```
2. ```cd InsurancePricingApp```
3. ```docker-compose up --build -d```
3. Install composer, run migrations ```docker exec -d php make init```
4. Add ```127.0.0.1 app.local``` to `/etc/hosts`
5. Import postman collection manually to hit endpoints
6. Open API (**swagger**) is available by `localhost:9009` 
and the URL: `http://localhost:9009/openapi/swagger/swagger.yaml`.
CORS problem has to be solved to enable hitting endpoints inside the Open API interface.

## DB connection
The DB is accessible on `localhost:3307` with `dbuser:dbpassword` and the name is `db_dev`

## Important
Composer can be updated inside the **php** container
All migrations should be run inside the **php** container
