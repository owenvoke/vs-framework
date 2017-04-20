# project-generic-video-site

## Running with Vagrant
1. Clone via Git with `git clone https://github.com/PXgamer/project-generic-video-site`
2. Just run `vagrant up` in the root directory.
3. That's all

## Setting up a Vagrant SSH tunnel
_This basically allows you to connect to the internal MySQL server running on Vagrant from an app such as PhpStorm._

#### SSH Tunnel Details:
**Host:** 127.0.0.1
**Username:** ubuntu  
**Private Key:** ./.vagrant/machines/default/virtualbox/private_key  
**Port:** 2222