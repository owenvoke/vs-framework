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

## Adding the Composer package repository

1. Browse to your global Composer config (`%AppData%\Composer\config.json` on Windows)
2. Copy in the following JSON
```json
{
  "repositories": [{
    "type": "composer",
    "url": "https://pxgamer:JXYPPJS45M9sPYg7G2bMEnNJ@packages.pxgamer.xyz"
  }]
}
```
You should now be able to run the following Composer command `composer search vs` which should return `vs/framework` as an option.

## Available modules

Modules are installed by running `composer install {module_name}`.

- `vs/framework` - The base framework for the VS site (required).
- `vs/api` - The API module for VS.