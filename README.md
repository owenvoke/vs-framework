# vs/framework

## Running with Vagrant
1. Clone via Git with `git clone https://github.com/PXgamer/vs-framework`
2. Run `composer install` in the root directory
3. Then run `vagrant up` in the root directory
4. That's all, you should now be able to browse to: [http://192.168.69.69](http://192.168.69.69)

## Setting up a Vagrant SSH tunnel
_This basically allows you to connect to the internal MySQL server running on Vagrant from an app such as PhpStorm._

#### SSH Tunnel Details:
**Host:** 127.0.0.1  
**Username:** ubuntu  
**Private Key:** `./.vagrant/machines/default/virtualbox/private_key`  
**Port:** 2222

## Creating a module

Modules are what VS uses to add additional routes to the framework. There are a few steps to doing this:

**Routes class**  
Each module requires a `Routes` class under the module namespace, for example with the Api module, this is: `\VS\Api\Routes`.  
This must extend the `VS\Framework\Routing\PluginRoute` class.  
Routes are defined using [`nezamy/route`][nezamy/route] as follows:  

```php
$Route->any('/', ['{controller_class}', '{method}']);
```

**Controller classes**  
Controllers should be located under a folder named `src/Controller`.  
These must extend the `\VS\Framework\Controller\Controller` class which enabled usage of Smarty and the database.

## Available modules

Modules are installed by running `composer install {module_name}`.

- [`vs/framework`][module/framework] - The base framework for the VS site (required).
- [`vs/api`][module/api] - The API module for VS.

[module/framework]: https://github.com/PXgamer/vs-framework
[module/api]: https://github.com/PXgamer/vs-api
[nezamy/route]: https://packagist.org/packages/nezamy/route
