<?php

namespace ReactDemo\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;
use Symfony\Component\Finder\Finder;

/**
 * Defines commands in the "react" namespace.
 */
class ReactCommand extends BltTasks {

  /**
   * Compile all the JS for development use.
   *
   * @command react:build:dev
   * @aliases react-build-dev
   */
  public function reactBuildDev() {
    foreach ($this->getFoldersWithWebpack() as $dir) {
      // Print the directory path to for user.
      $this->say($dir);

      // Build the files.
      $this->taskExec('npm run build:dev')
        ->dir($dir)
        ->run();
    }
  }

  /**
   * Compile all the JS for development use.
   *
   * @command react:build
   * @aliases react-build
   */
  public function reactBuild() {
    foreach ($this->getFoldersWithWebpack() as $dir) {
      // Print the directory path to for user.
      $this->say($dir);

      // Build the files.
      $this->taskExec('npm run build')
        ->dir($dir)
        ->run();
    }
  }

  /**
   * Compile all the JS for development use.
   *
   * @command react:validate
   * @aliases react-validate
   */
  public function reactValidate() {
    $this->taskExec('npm run lint')
      ->dir($this->getConfigValue('docroot') . '/modules/custom')
      ->run();
  }

  /**
   * Install the npm packages.
   *
   * @command react:setup
   * @aliases react-setup
   */
  public function reactSetup() {
    $this->taskExec('npm install')
      ->dir($this->getConfigValue('docroot') . '/modules/custom')
      ->run();
  }

  /**
   * Setup React during BLT frontend setup.
   *
   * @hook post-command source:build:frontend-reqs
   */
  public function reactSetupHook() {
    $this->reactSetup();
  }

  /**
   * Build all React files during frontend build.
   *
   * @hook post-command source:build:frontend-assets
   */
  public function reactBuildHook() {
    $this->reactBuild();
  }

  /**
   * This will be called post `git:pre-commit` command is executed.
   *
   * @hook post-command internal:git-hook:execute:pre-commit
   */
  public function postGitPreCommit($result, CommandData $commandData) {
    // @todo validate only if JS files are modified.
    // @todo validate only the modified JS files.
    $this->reactValidate();
  }

  /**
   * Invoke React validation post the BLT frontend validation.
   *
   * @hook post-command tests:frontend:run
   */
  public function postFrontendTests() {
    $this->reactValidate();
  }

  /**
   * Wrapper to get folders which require compiling.
   *
   * @return array
   *   Folders containing webpack.config.js file.
   */
  private function getFoldersWithJs() {
    $folders = [];

    $finder = new Finder();

    // Find all the folders containing the file used to specify entry points.
    $finder->name('webpack.config.js');

    // We need to find inside custom code only.
    $files = $finder->in($this->getConfigValue('docroot') . '/modules/custom');

    foreach ($files as $file) {
      $dir = str_replace('webpack.config.js', '', $file->getRealPath());

      // Ignore webpack.config.js found inside node_modules.
      if (strpos($dir, 'node_modules') > -1) {
        continue;
      }

      $folders[] = $dir;
    }

    return $folders;
  }

}
