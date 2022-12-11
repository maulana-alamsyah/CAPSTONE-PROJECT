<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config
set('ssh_multiplexing', false);
set('git_tty', false);

set('repository', 'https://github.com/maulana-alamsyah/CAPSTONE-PROJECT.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);



// Hosts

host('47.250.41.118')
    ->set('remote_user', 'root')
    ->set('deploy_path', '/var/www/html/staging/CAPSTONE-PROJECT');

// Hooks

after('deploy:failed', 'deploy:unlock');
