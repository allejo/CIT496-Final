# CIT 496 Final Project


This website is built on top of the [Symfony framework](http://symfony.com/) using the [FOSUserBundle](https://github.com/FriendsOfSymfony/FOSUserBundle) for user management.
## Installation
All of the dependencies for the website are maintained through [Composer](https://getcomposer.org/) and are defined the `composer.json` file.

If you're running a development environment, use composer without any flags to fetch all of the dependencies.

```bash
composer install
```

For a production environment, you will want to speed things up and not worry about debug/development tools, so ensure Composer knows about that.

```bash
export SYMFONY_ENV=prod
composer install --no-dev -o
```

Once all of the dependencies have been fetched, configure the `app/config/parameters.yml` file with your settings for running this website. If the file does not exist, make a copy of `parameters.yml.dist` and work from there.

After the website has been configured, set up the database structure by running database migrations created and maintained thorugh the [Doctrine Migrations Bundle](https://github.com/doctrine/DoctrineMigrationsBundle).

```bash
./bin/console doctrine:migrations:migrate
```

Once the database is set up, point your web server to the `web/` directory and your site is ready. The **only** directory that should be exposed to the Internet is the `web/` folder. I mean it. Anything else can lead to security issues, especially if `app/` is exposed, which contains our sensitive data such as database and email credentials.

## Security

Here are some security related topics and information.

### Password Hash

For password hashing, we are using the recommend [bcrypt algoritm](https://en.wikipedia.org/wiki/Bcrypt) for storing passwords in the database.

### Logins are tracked

Each successful login is tracked in the database as well as some failed login attempts. The only failed login attempts that are recorded are attempts on accounts that actually exist; invalid user accounts are not recorded.

### IP Addresses Recorded

The IP address of all logins, failed or successful, are tracked, which will allow us to flag suspicious IP addresses if it is the first time they are being used by a user.

### Secured Files

The only directory that is exposed to the Internet is the `web/` folder so all secured files are stored in the `/assets/secret/` directory, which is not exposed to the Internet. A Symfony controller is then used to read files from the filesystem and deliver them when requested.

## License

ALL RIGHTS RESERVED
