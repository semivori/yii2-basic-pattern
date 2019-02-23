HOW TO INSTALL
==============

**1)** Create a new MySQL database (charset: `utf_8_general_ci`).

**2)** Import of the following db files:

- `app\data\db_structure.sql`
- `app\data\countries-states-cities-database\cities.sql`
- `app\data\countries-states-cities-database\countries.sql`
- `app\data\countries-states-cities-database\states.sql`

**3)** Rename the following files:

- `app\config\console.local.php` => `app\config\console.php`
- `app\config\db.local.php` => `app\config\db.php`
- `app\config\params.local.php` => `app\config\params.php`
- `app\config\web.local.php` => `app\config\web.php`

**4)** Edit `app\config\db.php` and other config files if needed.

**5)** The following folders must have `0777` rules: 

- `uploads` (and all subfolders inside `uploads`)
- `app\runtime`
- `assets`

**6)** Go to the `app` folder and execute the next console command:

6.1) `composer global require fxp/composer-asset-plugin --no-plugins`
6.2) `composer install` OR `php composer.phar install`

**7)** When the DB is created and configured and all dependencies are installed, go to the `app` folder and execute the next console command:

`php yii migrate` OR `yii migrate`

**8)** Go to the created local website and create a new account. Then execute the following URL:

`http://{your_local_domain}/cron/queue`

**9)** Go to the folder `app\runtime\mail` and find an email with the activation link. Activate your account.


CRON Jobs
=========

Use the following URL every time you need to execute all background jobs (send emails, generate previews, generate PDF files etc.):

`http://{your_local_domain}/cron/queue`

GIT WORKFLOW
===========

**1)** We use the **[Git Feature Branch Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows/feature-branch-workflow)**.

**2)** Branch naming convention:

- `hotfix-{trello_card_id}-short_description`
- `feature-{trello_card_id}-short_description`

**Examples:**

- `feature-568-multi_file_upload`
- `hotfix-314-annotations_not_working`

Other Conventions:
=================

**1)** [JS](https://www.w3schools.com/js/js_conventions.asp) + [Best Practices](https://www.w3schools.com/js/js_best_practices.asp)

**2)** [PHP](https://github.com/php-fig/fig-standards/tree/master/accepted)

**3)** [SQL](http://www.sqlstyle.guide/)
