# React

This module provides basic library required for react to run with recommended
setup, it contains an example module to help you build custom react
modules.

# Prerequisites
- NPM version 14.x in your local or dev env (example Lando)
- From `docroot/modules/react` directory, Execute `npm install`

# How to build a new react module?
- Use `react_welcome` as example module: `docroot/modules/react/react_welcome`
- Copy files in your custom module from `docroot/modules/react/react_welcome` to use the existing packages
    -  `package.json`: Contains `scripts` to execute command from module directory.
    -  `.babelrc`: Contains babel related configs. we are using babel-loader with webapck.
    - `webpack.config.js`: We are using webpack to transpile js files
        - The Component and js files vary based on your module, hence you will
         have to update values for `entry` key.
        - For product purpose it would be nice to have single transpiled file, and
         to do that, For `entry` key; pass the array without any key like:
        `['./js/test', './js/custom']` and that will create single `main.js` file.
    - (optional) `gulpfile.js`:
        > :exclamation: To transpile *.js files, you won't require gulpfile.js But in case if
        you want to use gulpfile with webpack, the examples are added in the
        file. (ref: https://www.npmjs.com/package/gulp-webpack)

# Compile module's react/js files.
To build JS files
- Run the blt command
  - `blt react:build`
  - `blt react:build:dev` (For local development)
- For specific module during development do it from inside the module itself. For example to make react_welcome work on your local
  - go to directory `docroot/modules/react/react_welcome/`
  - `npm run build`
  - `npm run build:dev` (For local development)

# Manage dependencies between module's react/js while lazy loading.
If your component is included or lazy loaded in the other react modules, you have to run the React build script in that module as well to capture the changes in component within your module. If we won't the Travis build will only run react build script in your module but not in the other module using your module's component. This will result in chunk failed error on the site after the deployment.

Concept here is same as Drupal module dependencies. You have to add name of the module on which the current module depends on in the react_dependencies.txt file. For implementation, please follow the below steps:
- Add a file name `react_dependencies.txt` in the module using your module's component.
- Within the file, add your module's name.
- If multiple modules are servicing components to a single module, mention all the modules name one per line.
