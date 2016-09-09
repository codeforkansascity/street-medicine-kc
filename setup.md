## Vagrant Setup for development

The vagrant uses [Scotch Box](https://box.scotch.io/)

* Install [Vagrant](https://www.vagrantup.com/)
* Install [VirtualBox](https://www.virtualbox.org/wiki/Downloads)
* Run `vagrant up` in the source root directory
* Access the site at http://192.168.33.10

### MySQL

The provisioned VM will have MySQL running with default user `root` with password `root`.

Run the following command to create homeless_kc database.

```shell
$ vagrant ssh -c "mysql -u root -p -e 'create database homeless_kc;'"
Enter password:
Connection to 127.0.0.1 closed.
```

Now, if you do `show databases`, it should show the database created.

```shell
$ vagrant ssh -c "mysql -u root -p -e 'show databases;'"
Enter password:
+--------------------+
| Database           |
+--------------------+
| information_schema |
| homeless_kc        |
| mysql              |
| performance_schema |
| scotchbox          |
+--------------------+
Connection to 127.0.0.1 closed.
```

Update db configuration files and you should be setup.

#### Import DB dump

There are database dumps in [db_dump](db_dump) directory. You can import one of those by running the following command:

```shell
vagrant ssh -c "mysql -u root -p homeless_kc < /var/www/public/db_dump/Dump20160730.sql"
```

If you want to run commands interactively over SSH session in your VM, you can always enter a shell via `vagrant ssh`.

### Vagrant

#### SSH Access

If you need to access the virtual machine, you can ssh using `vagrant ssh` command.

#### Shutdown VM

```shell
vagrant halt
```

#### Use VM over system restarts

Before shutting down the host system, suspend the VM.

```shell
vagrant suspend
```

Next time, you can just run:

```shell
vagrant up
```
