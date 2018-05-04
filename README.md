# MyCryptool

[![Build Status](https://travis-ci.org/kevindh89/mycryptool.svg?branch=master)](https://travis-ci.org/kevindh89/mycryptool)

MyCryptool is a useful tool to manage and keep track of your cryptocurrency trades (GDAX platform support only).

*Prerequisites:* To run this project locally you need to have [docker-compose](https://docs.docker.com/compose/install/) installed.

## Setup

Run setup script:
```
./setup.sh
```

Add this line to your ``/etc/hosts`` file:
```
127.0.0.1 mycryptool.test
```

__MyCryptool__ should now be available on http://mycryptool.test and show "MyCryptool is working!".

## Connect to GDAX

Connect __MyCryptool__ to your __GDAX__ account using API credentials (``access token``, ``secret`` and ``passphrase``).
These can be obtained from the [GDAX API settings](https://www.gdax.com/settings/api) page.

Update the ``.env`` file in the project root directory with the API credentials:

```
GDAX_LEGAL_NAME=''
GDAX_API_KEY=''
GDAX_SECRET=''
GDAX_PASSPHRASE=''
```

### Working endpoints

After configuring the API credentials, this endpoint should give a valid HTTP 200-response:

__Trading rate (BTC-EUR)__: http://mycryptool.test/api/rate/BTC-EUR 

## Testing

Run unit tests:
```
vendor/bin/phpunit
```


## Copyright and license

Code released under the [MIT License](https://github.com/kevindh89/mycryptool/blob/master/LICENSE).