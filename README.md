# Podcast Backend Statistics
A Tech Test

### Getting set-up.
Upon cloning the application in order to get this process working you are going to want to run the following: 

```
docker-compose build && \
docker-compose up -d && \
docker-compose exec php composer install && \
docker-compose exec php php artisan migrate:fresh --seed && \
docker-compose exec -d php crond -f
```

explaining docker-compose exec -d php crond -f: when running the above command in general, it's going to start up and utilise the cron service in order for random downloads to be executed (every minute).

### Variables for .env
We are going to be in need of a .env (this file should never make it to version control). and thus we're going to need to make a copy of the .env.example so that we can utilise this as the local environment for development. Upon cloning example environment we can then generate a key.
```
cp ./.env.example ./.env
docker-compose exec php php artisan key:generate
```

if you're using windows, I question it but alas; 
```
copy ./.env.example ./.env
```

Then head on over to localhost:8088

### Testing
The application is equipped with some basic unit tests. in order to achieve the running of this you can run the following: 
```
docker-compose exec php php artisan test
```

### Decisions: 
- port 4306 on the database, because 3306 is already in use on my local machine. 
- port 8088 on the application because 80 and 8080 are currently already in use on my local machine.
- PodcastDownloaded for event and listener for easier knowledge of mapping forcing an explicit map.
- PodcastEpisodeDownloaded for event and listener for easier knowledge of mapping forcing explicit map.

### notes on what could have been better:
- The frontend was unnecessary and potentially took more time than it needed to, and could have just primarily focused on making the PHP side of things. (however the decision was entirely to create something that I could visualise whilst going along with it)
- The naming convention of the docker services could have been a little more targetted; unfortunate to write docker-compose exec php php artisan the double php was a trigger point for myself. in an ideal world these services would have been named respsectively to their design. i.e: 
    - service php: **podcast-app**
    - service mariadb: **podcast-mariadb**
    - service nginx: **podcast-nginx**
- be more specific with name spaces; however chosen to utilise the same name for event and listener so that it'd be more specific to what the developer will have to map to what. as a personal choice this was for more explicit event listener mappings than anything; but created some unnecessary aliasing for classes.
- setup a database for unit/feature testing that's allowing of being cleaned and seeded which mimics the actual setup, having two differential databases for testing can warrant false positives|negatives and doesn't reflect the system as it stands.

### Things I wanted to do: 
I wanted to take use of websockets, setting up a frontend that consumes the events that are being made within the application. having the frontend auto update when new downloads happen rather than having to refesh the page to see changes.
