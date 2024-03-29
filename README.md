
# Job Board
A pretty simplified Docker Compose workflow that sets up a LAMP network of containers for local Laravel development and testing. This project was done using both VueJs and normal laravel eloquoent. 


## How to run

After cloning the repo copy environment file from .env.example `cp .env.example .env`
To get started, make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) on the system, and then clone this repository and spin up the containers for the web server by running 
- `docker-compose up -d --build`.

After that completes following are built for our web server, with their exposed ports detailed:

- **nginx** - `:8080`
- **mysql** - `:3306`
- **php** - `:9000`

## Build Vue version
Once build and successful running of the containers, run following command for the Vue Version
- `docker-compose run --rm npm run build`

## Database Migration
After copy the environment and docker compose successfully built and running, run artisan for database migration
- `docker-compose run --rm artisan migrate`


## Useful Commands 
Two additional containers are included that handle NPM, and Artisan commands *without* having to have these platforms installed on your local computer. Use the following command examples from your project root, modifying them to fit your particular use case.

- `docker-compose run --rm npm install`
- `docker-compose run --rm artisan migrate` 

Besides these other containers can be accessible using below commands

- `docker-compose exec app bash` 
- `docker-compose exec app composer install` 
- `docker-compose exec db bash` 

## Tests setup and Run
To run automated test we will use sqlite db, create an sqlite database named 'test.sqlite' inside database folder `database/test.sqlite` 
or run this command to create one `docker-compose exec app touch database/test.sqlite` 
or create the database name same as you define in `.env.testing`
Run the following command to run tests 
- `docker-compose exec app composer test` 

## Future Improvements
- Add task schedular to get jobs from API periodically
- Add caching and writiing more unit tests

## Reference
API used for job details `https://paikat.te-palvelut.fi/tpt-api/tyopaikat?englanti=true`

## Inspired and Supported By:
[https://bitbytesoft.com](https://bitbytesoft.com)
[https://bitbyhost.com](https://bitbyhost.com)
