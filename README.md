# MyCryptool

## Setup

Start containers with docker-compose:
```
docker-compose up -d --build
```

Add this line to your ``/etc/hosts`` file:
```
192.168.99.100 mycryptool.test
```

__MyCryptool__ should now be available on [http://mycryptool.test](http://mycryptool.test) and show "MyCryptool is working!".

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

_Rates_: http://192.168.99.100:8080/api/rates

_Orders_: http://192.168.99.100:8080/api/orders
