# Project 3 - Jobpermut

![Treeb'Z](https://user-images.strikinglycdn.com/res/hrscywv4p/image/upload/c_limit,fl_lossy,h_300,w_300,f_auto,q_100/1771008/692650_575797.png)

## index
1. [Description](#Description)
2. [Prerequisites](#Prerequisites)
3. [Installation](#Installation)
4. [Built-With](#Built-With)
5. [Authors](#Authors)

## Description

Treeb'Z is an e-commerce that sells a customized game of 7 families.

## Prerequisites

* [PHP 7.4.*](https://www.php.net/releases/7_4_0.php) (check by running php -v in your console)
* [Composer 2.*](https://getcomposer.org/) (check by running composer --version in your console)
* [node 14.*](https://nodejs.org/en/) (check by running node -v in your console)
* [Yarn 1.*](https://yarnpkg.com/) (check by running yarn -v in your console)
* [MySQL 8.0.*](https://www.mysql.com/fr/) (check by running mysql --version in your console)
* [Git 2.*](https://git-scm.com/) (check by running git --version in your console)
* [Cropper JS/Symfony UX*](https://github.com/symfony/ux-cropperjs) (install by running _composer require symfony/ux-cropperjs_)
* [VichUploaderBundle*](https://github.com/dustin10/VichUploaderBundle/blob/master/docs/index.md) (install by running _composer require vich/uploader-bundle_)
* * You will also need a test SMTP connection, which you can configure using tools like Mailtrap
*  # Don't forget to install the JavaScript dependencies as well and compile

## Installation
If you meet the prerequisites, you can proceed to the installation of the project 

1. Clone the project from [Github](https://github.com/WildCodeSchool/orleans-202103-php-project-treebz)
2. Open the project folder with your code editor
3. Open the terminal and run the following commands:
4. Run `composer install` to install PHP dependencies
5. Run `yarn install` to install JS dependencies
6. Copy the `.env` file, rename it to `.env.local` and fill it with all the needed informations (Database, Symfony/Mailer)
8. Run `symfony console doctrine:database:create` to create database
9. Run `symfony console doctrine:migration:migrate` to create structure of database
10. In order to properly load the fixtures, inside the folder `public/uploads`, create a folder named `themes` and another named `members`
11. Run `symfony console doctrine:fixtures:load` to load the fixtures in database
12. Run `yarn encore dev` to build assets
13. Run `symfony server:start` to launch symfony server
14. Go to localhost:8000 on your browser

## Built-With

* [Symfony](https://github.com/symfony/symfony)
* [GrumPHP](https://github.com/phpro/grumphp)
* [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer)
* [PHPStan](https://github.com/phpstan/phpstan)
* [PHPMD](http://phpmd.org)
* [ESLint](https://eslint.org/)
* [Sass-Lint](https://github.com/sasstools/sass-lint)

## Authors

* [Aurélien Vannier](https://github.com/Vannou28)
* [Christian Olmedo](https://github.com/ChristianOlmedo)
* [Gersey Stelmach](https://github.com/gerseystelmach)
* [Valentin Lay](https://github.com/Valentin-int)

