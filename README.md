Onsen UI Project
====

This document describes the minimum information required to develop an app using Onsen UI.

## Requirement

 * Node.js - [Install Node.js](http://nodejs.org)
 * Cordova - Install by `npm install cordova`, or Monaca CLI - `npm install monaca-cli`

## Development Instructions

All dependencies are downloaded by default in `www/lib` directory.
`package.json` contains all the required dependencies.


### Directory Layout

    www/          --> Asset files for app
      index.html  --> App entry point
      js/
      lib/       --> External dependencies
      scripts/    --> Cordova scripts directory
    platforms/    --> Cordova platform directory
    plugins/      --> Cordova plugin directory
    merges/       --> Cordova merge directory
    hooks/        --> Cordova hook directory

### Developing with React:
  1. Install dev dependencies: `npm install --only=dev`
  2, Transpile `www/js/app.jsx` to `www/js/app.js` by running `npm generate`
