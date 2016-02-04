# RendezView

A scalable mobile ready room scheduling and appointment management web based application. Tools used in the project include Laravel PHP framework, MySQL, JQuery, and Bootstrap CSS framework.  This project was created at Drexel University as my senior design project in the spring of 2014.

## Demo

You can view a live demo of Rendezview [here](http://rendezview.ehumps.me).

##Requirements and Installation

* In order to follow the installation steps below you must be using [vagrant](https://www.vagrantup.com/) for local development.  Included in this repository is a [Vagrantfile](https://github.com/ehumps/rendezview/blob/master/Vagrantfile) and an [installation script](https://github.com/ehumps/rendezview/blob/master/install.sh) to mostly automate the setup of your local development environment.

---

1. Clone the project.

2. In the cloned directory, run `vagrant up`.

3. Once the virtual machine is provisioned, run `vagrant ssh`.

4. Change directory to the git repository being shared to the VM `cd ../../vagrant`.

5. Install composer dependencies `sudo composer install`.

6. Migrate and seed the database `php artisan migrate --seed`.

7. Duplicate the .htaccess examples `cp .htaccess.example .htaccess` & `cp public/.htaccess.example public/.htaccess`.

8. Browse to `http://localhost:8080/`.

Two accounts are created by default:

| Username      | Password      |
| :-----------: |:-------------:|
| admin         | admin         |
| user          | user          |

The current app/config/database.php file expects a MySQL database connection using the following name and credentials.  You may update these to suit your own setup if you choose to not run the vagrant steps above:

| Database      | Username      | Password      |
|:-------------:|:-------------:|:-------------:|
| rendezview    | root          | root          |


The app/config/mail.php file has been set to `'pretend' => false` - so SMTP settings are required.

## Dependencies

This project utilizes several external dependencies as seen in the composer.json file as well as the frameworks and technologies mentioned above:

* [way/generators](https://github.com/JeffreyWay/Laravel-4-Generators/)
* [laravelbook/ardent](https://github.com/laravelbook/ardent/)
* [zizaco/confide](https://github.com/zizaco/confide/)
* [zizaco/entrust](https://github.com/zizaco/entrust/)
* [barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar/)
* [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf/)
* [bllim/datatables](https://github.com/bllim/laravel4-datatables-package/)
* [andrewelkins/Laravel-4-Bootstrap-Starter-Site](https://github.com/andrewelkins/Laravel-4-Bootstrap-Starter-Site)
* [moment.js](http://momentjs.com/)
* [mmenu](http://mmenu.frebsite.nl/)
* [ladda](http://lab.hakim.se/ladda/)
* [fullCalendar](http://fullcalendar.io/docs1/)

## License

Rendezview is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
