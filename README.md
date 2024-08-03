# Apple Business Connect API

This is a php client for the Apple Business Connect API.  
The Apple Business Connect API is a RESTful API that allows you to access information about businesses that are registered with Apple Business Connect.

## Installation

```bash
composer require developermarius/apple-business-connect-api
```

## Usage

```php
use developermarius\applebusinessconnect\api\AppleBusinessConnectClient;

$api = new AppleBusinessConnectClient('' /* Your client id */, '' /* Your client secret */, '' /* Your company id */);

$api->getLocations();
```

## TODO
- [ ] Implement new category taxonomy for businesses
- [ ] Implement OAuth2
- [ ] Documentation
