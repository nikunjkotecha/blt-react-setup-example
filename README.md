# Exmaple for Drupal projects with React code

This project example on how to add React JS in different custom modules in your repo.

## Provides

* BLT [Command file](blt/src/Blt/Plugin/Commands/ReactCommand.php) which
  * Hooks into frontend:setup
  * Hooks into frontend:build
  * Hooks into frontend:validate
  * Hooks into git pre-commit
  * Exposes BLT commands to
    * Setup React `blt react:setup`
    * Compile dev version of JS files `blt react:build:dev`
    * Compile production version of JS files `blt react:build`
    * Validate all the JS files `blt react:validate`

## Usage
* Copy the BLT commands file ReactCommand.php in your repo and change the namespace
* Copy [package.json](docroot/modules/custom/package.json) and [package-lock.json](docroot/modules/custom/package-lock.json) into your repo inside the same folder
* Check the [README.md](docroot/modules/custom/README.md) for further steps to set up a React module
