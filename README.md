# MyCryptool

To run this project locally you need to have [docker-compose](https://docs.docker.com/compose/install/) installed.

## Setup

Start containers with docker-compose:
```
docker-compose up -d --build
```

Run database migrations to create the database:
```
php bin/console doctrine:migrations:migrate
```

Install frontend package dependencies:
```
npm install
```

Compile css and js files with webpack:
```
./node_modules/.bin/encore dev
```

Add this line to your ``/etc/hosts`` file:
```
192.168.99.100 mycryptool.test
```

__MyCryptool__ should now be available on http://mycryptool.test and show "MyCryptool is working!".

## Connect to GDAX

Connect __MyCryptool__ to your __GDAX__ account using API credentials (``access token``, ``secret`` and ``passphrase``).
These can be obtained from the [GDAX API settings](https://www.gdax.com/settings/api) page.

Update the ``.env`` file in the project root directory with the API credentials:

```
GDAX_API_KEY=''
GDAX_SECRET=''
GDAX_PASSPHRASE=''
```

Now restart the docker containers to update the changed environment variables:

```
docker-compose restart
```

### Working endpoints

After configuring the API credentials, these endpoints should give valid json responses:

_Rates_: http://mycryptool.test/api/rates

_Orders_: http://mycryptool.test/api/orders


## Copyright and license

Code released under the [MIT License](https://github.com/kevindh89/mycryptool/blob/master/LICENSE).