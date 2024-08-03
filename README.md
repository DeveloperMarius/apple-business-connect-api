# Apple Business Connect API

This is a php client for the Apple Business Connect API.

## Installation

```bash
composer require developermarius/apple-business-connect-api
```

## Usage

```php
use DeveloperMarius\AppleBusinessConnectApi\AppleBusinessConnectApi;

$api = new AppleBusinessConnectApi('' /* Your client id */, '' /* Your client secret */, '' /* Your company id */);

$api->getLocations();
```

## TODO
- [ ] Implement new category taxonomy for businesses
- [ ] Implement OAuth2