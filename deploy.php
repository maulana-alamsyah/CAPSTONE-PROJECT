<?php

namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/npm.php';
/* require 'contrib/rsync.php'; */

// Config

set('repository', 'git@github.com:maulana-alamsyah/CAPSTONE-PROJECT.git');
set('application', 'CAPSTONE-PROJECT');
set('ssh_multiplexing', true);  // Speed up deployment

/* set('rsync_src', function () {
    return __DIR__; // If your project isn't in the root, you'll need to change this.
});

// Configuring the rsync exclusions.
// You'll want to exclude anything that you don't want on the production server.
add('rsync', [
    'exclude' => [
        '.git',
        '/vendor/',
        '/node_modules/',
        '.github',
        'deploy.php',
    ],
]); */

// Set up a deployer task to copy secrets to the server.
// Grabs the dotenv file from the github secret
task('deploy:secrets', function () {
    file_put_contents(__DIR__ . '/.env', getenv('DOT_ENV'));
    upload('.env', get('deploy_path') . '/shared');
});

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('47.250.41.118') // Name of the server
    ->setHostname('47.250.41.118') // Hostname or IP address
    ->set('remote_user', 'root') // SSH user
    ->set('branch', 'main') // Git branch
    ->set('deploy_path', '/var/www/html/staging/CAPSTONE-PROJECT'); // Deploy path


/* host('47.250.41.118')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/var/www/html/staging/CAPSTONE-PROJECT'); */

// Hooks

after('deploy:failed', 'deploy:unlock');

///////////////////////////////////
// Tasks
///////////////////////////////////

desc('Start of Deploy the application');

task('deploy', [
    'deploy:prepare',   // Deploy code & built assets
    'deploy:secrets',       // Deploy secrets
    'deploy:vendors',
    'deploy:shared',        // 
    'artisan:storage:link', //
    'artisan:view:cache',   //
    'artisan:config:cache', // Laravel specific steps
    'artisan:queue:restart', //
    'deploy:publish',       // 
]);

desc('End of Deploy the application');
