
# Job Board
A pretty simplified Docker Compose workflow that sets up a LAMP network of containers for local Laravel development and testing. 


## Usage

After cloning the repo copy environment file from .env.example `cp .env.example .env`
To get started, make sure you have [Docker installed](https://docs.docker.com/docker-for-mac/install/) on the system, and then clone this repository and spin up the containers for the web server by running `docker-compose up -d --build`.

After that completes following are built for our web server, with their exposed ports detailed:

- **nginx** - `:8080`
- **mysql** - `:3306`
- **php** - `:9000`


## Database MIgration
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

## Tests
To run automated test we will use sqlite db, create an sqlite database named 'test.sqlite' inside database folder `database/test.sqlite` 
Run the following command to run tests 
- `docker-compose exec app composer test` 

## Future Improvements
- Add task schedular to get jobs from API periodically
- Add caching and unit testing(at this point there is no suitable functionality to implement unit tests)
