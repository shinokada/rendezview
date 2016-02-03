# RendezView

A scalable mobile ready room scheduling and appointment management web based application. Tools used in the project include Laravel PHP framework, MySQL, JQuery, and Bootstrap CSS framework.

## Demo

You can view a live demo of Rendezview [here](http://rendezview.ehumps.me).

##Requirements and Installation

* I recommend using [vagrant](https://www.vagrantup.com/) for local development.  Included in this repository is a [Vagrantfile](https://github.com/ehumps/rendezview/blob/master/Vagrantfile) and an [installation script](https://github.com/ehumps/rendezview/blob/master/install.sh) to get your local development environment ready.

---

1. Clone the project

2. In the cloned directory, run `vagrant up` to provision a virtual machine.

3. Once the virtual machine is provisioned, run `vagrant ssh` to ssh into the VM.

4. Change directory to the git repository being shared to the VM. `cd ../../vagrant`

5. Install composer dependencies `sudo composer install`

6. Migrate and seed the database `php artisan migrate --seed`

7. Browse to `http://localhost:8080/`

Two accounts are created by default:

| Username      | Password      |
| :-----------: |:-------------:|
| admin         | admin         |
| user          | user          |

The current app/config/database.php file expects a MySQL database connection using the following name and credentials (Update these to suit your own setup):

| Database      | Username      | Password      |
|:-------------:|:-------------:|:-------------:|
| rendezview    | root          | root          |


The app/config/mail.php file has been set to `'pretend' => false` - so SMTP settings are required.


## License

This is free software distributed under the terms of the MIT license
