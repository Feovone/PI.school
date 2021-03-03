# Final Back

## Build Setup

```bash
# install dependencies
$ composer install

# fill the environment (DB,Mail,etc)

# migrate DB
$ php artisan migrate

# configurate web server (apache example[1]) and launch server 

# configurate mail for a specific platform[2]
# execution of the sendEmail command is already preset in the project in kernel> schedule
```
## Features
```bash
# The command generates user data for 2 years 
$ artisan generate:id {id}

# The project has documentation on api "/api/docs"

```
## Links

 1. Configure  [Apache](https://gitlab.com/Feovone/pi.school/-/tree/master/Week6-9)
 2. Configuration for: 
 - [Linux](https://laravel.com/docs/8.x/scheduling#running-the-scheduler) Laravel official docs
 - [Windows](https://docs.microsoft.com/en-us/windows-server/administration/windows-commands/schtasks) launch through the scheduler Windows
