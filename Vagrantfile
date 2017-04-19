Vagrant.configure("2") do |config|
	# OS
	config.vm.box = "ubuntu/xenial64"

	# Create a private network
	config.vm.hostname = "vagrant.dev"
	config.vm.network "private_network", ip: "192.168.69.69"

	# Synced folder with the VM
	config.vm.synced_folder ".", "/vagrant"

	# VM custom settings
	config.vm.provider "virtualbox" do |vb|
		vb.name = "vagrant_dev"
		vb.customize ["modifyvm", :id, "--memory", "2048"]
		vb.customize ["modifyvm", :id, "--cpus", "1"]
		vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
		vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
	end  

	# Enable provisioning with a shell script.
	config.vm.provision "shell", path: "_dev/vagrant.sh", keep_color: true
end