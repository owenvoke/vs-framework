# vs/framework

## Installation
1. Clone via Git with `git clone https://github.com/PXgamer/vs-framework`
2. Run `composer install` in the root directory
3. Run the SQL code (`resources/dump.sql`)
4. That's all, you should now be able to browse to your chosen URL (Example: `php -S localhost:69`, then browse to [localhost:69](https://localhost:69)

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

Using Smarty from within a controller is as simple as using `$this->smarty`, for example:
```php
$this->smarty->display(
    '{template}.tpl',
    [
        'variable' => 'value'
    ]
);
```

You can also use the \PDO functions from `$this->db` such as:
```php
$this->db->query('SELECT * FROM users');
```

Also available is the `Account` class from `$this->user` which allows you to use functions such as:
```php
$this->user::auth();
$this->user::user($key);
$this->user->login($username, $password);
$this->user->logout();
$this->user->register($data);
```

## Available modules

Modules are installed by running `composer install {module_name}`.

- [`vs/framework`][module/framework] - The base framework for the VS site (required).
- [`vs/api`][module/api] - The API module for VS.

[module/framework]: https://github.com/PXgamer/vs-framework
[module/api]: https://github.com/PXgamer/vs-api
[nezamy/route]: https://packagist.org/packages/nezamy/route
