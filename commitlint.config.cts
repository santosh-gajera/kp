/**
 * Commitlint - To make sure your adding helpful commits ;)
 * 
 * --- Commit Subject Types ---
 * 
 *  `build`    = Changes that affect the build system or external dependencies (example scopes: gulp, broccoli, npm)
 *  `ci`       = Changes to our CI configuration files and scripts (example scopes: Travis, Circle, BrowserStack)
 *  `docs`     = Documentation only changes
 *  `feat`     = A new feature
 *  `fix`      = A bug fix
 *  `perf`     = A code change that improves performance
 *  `refactor` = A code change that neither fixes a bug nor adds a feature
 *  `style`    = Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
 *  `test`     = Adding missing tests or correcting existing tests
*/

const config = {
    extends: ['@commitlint/config-conventional']
}

export default config;