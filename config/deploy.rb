# frozen_string_literal: true

require 'mina/rails'
require 'mina/git'
# require 'mina/rbenv'  # for rbenv support. (https://rbenv.org)
require 'mina/rvm' # for rvm support. (https://rvm.io)
require 'mina/puma'

# Basic settings:
#   domain       - The hostname to SSH to.
#   deploy_to    - Path to deploy into.
#   repository   - Git repo to clone from. (needed by mina/git)
#   branch       - Branch name to deploy. (needed by mina/git)

set :application_name, 'exchange'
set :domain,           '109.120.152.45'
set :deploy_to,        '/var/www/exchange_api'
set :repository,       'git@bitbucket.org:VladimirPalych/exchange_api.git'
set :branch,           'master'

# Optional settings:
set :user, 'deploy' # Username in the server to SSH to.
#   set :port, '30000'           # SSH port number.
#   set :forward_agent, true     # SSH forward_agent.

# Shared dirs and files will be symlinked into the app-folder by the 'deploy:link_shared_paths' step.
# Some plugins already add folders to shared_dirs like `mina/rails` add `public/assets`, `vendor/bundle` and many more
# run `mina -d` to see all folders and files already included in `shared_dirs` and `shared_files`
set :shared_dirs,  fetch(:shared_dirs,  []).push('storage', 'vendor')
set :shared_files, fetch(:shared_files, []).push('.env')

# This task is the environment that is loaded for all remote run commands, such as
# `mina deploy` or `mina rake`.
task :remote_environment do
  # If you're using rbenv, use this to load the rbenv environment.
  # Be sure to commit your .ruby-version or .rbenv-version to your repository.
  # invoke :'rbenv:load'

  # For those using RVM, use this to load an RVM version@gemset.
  invoke :'rvm:use', 'ruby-2.4.2@default'
end

# Put any custom commands you need to run at setup
# All paths in `shared_dirs` and `shared_paths` will be created on their own.
task :setup do
  # command %{rbenv install 2.3.0 --skip-existing}
end

desc 'Deploys the current version to the server.'
task :deploy do
  # uncomment this line to make sure you pushed your local branch to the remote origin
  # invoke :'git:ensure_pushed'
  deploy do
    # Put things that will set up an empty directory into a fully set-up
    # instance of your project.
    invoke :'git:clone'
    invoke :'deploy:link_shared_paths'
    command %{composer install}
    command %{php artisan migrate}
    invoke :'deploy:cleanup'
    on :launch do
      command %{composer dumpautoload}
      # command %{php artisan clear:data}
      command %{php artisan config:clear}
      command %{php artisan l5-swagger:generate}
      command %{php artisan queue:restart}
      command %{sudo supervisorctl reread}
      command %{sudo supervisorctl update}
      command %{sudo supervisorctl start laravel-worker:*}
      command %{sudo service php7.1-fpm restart}
    end
  end

  # you can use `run :local` to run tasks on local machine before of after the deploy scripts
  # run(:local){ say 'done' }
end

# For help in making your deploy script, see the Mina documentation:
#
#  - https://github.com/mina-deploy/mina/tree/master/docs
