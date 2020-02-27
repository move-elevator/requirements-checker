[![Build Status](https://travis-ci.org/move-elevator/requirements-checker.svg?branch=master)](https://travis-ci.org/move-elevator/requirements-checker)

# Requirements-checker

This is a package to check system settings for an easier communication with third party hosters, administrators or 
devops.

The idea of the package came from many feedback loops with external administrators for individual systems. 
To prevent many emails with something like "try again now", we started to develop a simple way to show that a system is 
ready. 

## Usage
* take a look at the `build`-folder to see an example
   * you can call it in your browser
       * append get-parameter like `?config-file=YOUR_YAML_FILE`
   * you can call it as a console command
       * example call
            ```
            php ./build/requirements-checker.phar ./build/example-config.yaml
            ```
* edit the `yaml`-file to fill up your needs
* for 

## Available checks
* AccessFileSystem
    * check if a file can be written and deleted to a specific folder
* ApcCache
    * check if apc or apcu cache is enabled 
* PhpClass
    * can check the presence of given php classes  
* PhpExtension
    * check if the given php extension is loaded  
* PhpFunction
    * check if the given php function exists  
* PhpIniSetting
    * check if the given php ini values are available through ini_get  
* PhpMinimalVersion
    * check if the given php version is fulfilled  
* SystemDateTime
    * check if `DateTimeImmutable` is callable and prints out the current time to prevent a wrong server time   

## Extend checks
You can write your own checks, by using the `checker-namespaces` property and fulfill the `CheckerInterface`.

## SCA & Tests
Run each command in the project root directory.

### Execute PHPUnit tests
```
./vendor/bin/phpunit.phar -c ./phpunit.xml --testdox
```

### Execute PHPSTAN checks

```
./vendor/bin/phpstan.phar analyse -l max -c ./phpstan.neon ./src
```

### Execute PHPCS checks

```
./vendor/bin/phpcs.phar ./src ./tests --standard=./ruleset.xml --extensions=php
```

### create and update phar-file 
```
./vendor/bin/phar-box.phar compile
```
  
### pure check with built-in server  
* run for local development
```
php -S localhost:8000 -t ./public
```
* run from built phar file
```
php -S localhost:8000 -t ./build
```

### Trouble shooting ###
#### usage with phar
```
disabled by the php.ini setting phar.readonly
```
* got to your php.ini
* set the following flag:
  * phar.readonly = Off
  
