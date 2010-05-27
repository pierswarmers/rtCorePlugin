# rtCorePlugin

The `rtCorePlugin` is the cetral and only required-by-all plugin for the Reditype suite. It contains a set of common and required pieces, around which, all other Reditype plugins are built.

In summary these core features include:

 * Search
 * Helpers
 * Models, and;
 * A selection of modules.

## Pre-Installation

You'll need to have an active Symfony 1.4 project before getting started with the installation.

    mkdir retitype_project
    cd retitype_project
    symfony1.4 generate:project retitype_project

You'll also need to configure a database...

    mysqladmin -uroot -pmyDbPassword create retitype_project

...and make sure the account settings are reflected in `config/databases.yml`:

    all:
      doctrine:
        class: sfDoctrineDatabase
        param:
          dsn: 'mysql:host=localhost;dbname=retitype_project'
          username: root
          password: myDbPassword

## Installation

1. Download the `rtCorePlugin` into you plugins directory along with the followong plugins:

        cd plugins
        git clone git://github.com/pierswarmers/rtBlogPlugin.git
        git clone git://github.com/pierswarmers/rtCorePlugin.git
        git clone git://github.com/pierswarmers/rtSitePlugin.git
        git clone git://github.com/pierswarmers/rtWikiPlugin.git

        svn co http://svn.symfony-project.com/plugins/sfDoctrineActAsTaggablePlugin/trunk/ sfDoctrineActAsTaggablePlugin
        svn co http://svn.symfony-project.com/plugins/sfDoctrineGuardPlugin/trunk/ sfDoctrineGuardPlugin
        svn co http://svn.symfony-project.com/plugins/sfFeed2Plugin/branches/1.2/ sfFeed2Plugin
        svn co http://svn.symfony-project.com/plugins/sfFormExtraPlugin/branches/1.3/ sfFormExtraPlugin
        svn co http://svn.symfony-project.com/plugins/sfGeshiPlugin/trunk sfGeshiPlugin
        svn co http://svn.symfony-project.com/plugins/sfThumbnailPlugin/trunk/ sfThumbnailPlugin
        ls -lash
        cd ..

2. Enable the plugin in your `ProjectConfiguration.class.php`, The enabled plugins call will look something like this:

        $this->enablePlugins(
        'rtCorePlugin',
        'rtBlogPlugin',
        'rtSitePlugin',
        'rtWikiPlugin',
        'sfDoctrinePlugin',
        'sfDoctrineActAsTaggablePlugin',
        'sfFormExtraPlugin',
        'sfDoctrineGuardPlugin',
        'sfGeshiPlugin',
        'sfThumbnailPlugin',
        'sfFeed2Plugin'
        );

3. You need a frontend application, if you don't already have one:

        ./symfony generate:app frontend

4. Enable the required modules in your fontend `apps/frontend/config/settings.yml`:

            enabled_modules:
              - rtWikiPage
              - rtBlogPage
              - rtSitePage
              - rtAsset
              - rtAdmin
              - rtSitePageAdmin
              - rtBlogPageAdmin
              - rtWikiPageAdmin
              - rtGuardUserAdmin
              - rtGuardGroupAdmin
              - rtTreeAdmin
              - rtSearchAdmin
              - rtGuardPermissionAdmin
              - rtDefault
              - rtSearch
              - rtGuardAuth
              - rtGuardForgotPassword
              - rtGuardRegister

5. While we're here, lets set up the email configuration in `factories.yml`:

            all:
              mailer:
                class: sfMailer
                param:
                  logging:           %SF_LOGGING_ENABLED%
                  charset:           %SF_CHARSET%
                  delivery_strategy: realtime
                  transport:
                    class: Swift_SmtpTransport
                    param:
                      host:       my.smtp.server.location.com
                      port:       485
                      encryption: ~
                      username:   no-reply@example.com.au
                      password:   123456

6. Two addition filters need to be enabled.

    In `apps/frontend/config/filters.yml`, you should have something like the following:

            rendering: ~

            remember_me:
              class: sfGuardRememberMeFilter

            security:  ~

            # insert your own filters here
            rt_admin_toolbar:
              class: rtAdminToolbarFilter

            cache:     ~
            execution: ~


7. Symfony will now need to be told how user authentication should be handled.

    In the `apps/frontend/lib/myUser.class.php`, change the exteded class:

        <?php

        class myUser extends sfGuardSecurityUser
        {
        }

    Now we need to configure the user management modules in `apps/frontend/config/settings.yml`:

        all:
          .settings:
            login_module:           rtGuardAuth
            login_action:           sirtin
            secure_module:          rtGuardAuth
            secure_action:          secure

    While you're at... wy not add the custom 404 handling:

        all:
          .settings:
            error_404_action: error404
            error_404_module: rtDefault

8. You will now need to run a complete build on your project:

        ./symfony doctrine:build --all
        ./symfony cc
        ./symfony plugin:publish-assets

9. You're done!

## Wrap-up

You'll probably want to create a user with some permissions. Its simple to do from the cli using the following task:

    ln -s ../../plugins/rtCorePlugin/data/fixtures/guard.yml.sample data/fixtures/guard.yml
    ./symfony doctrine:data-load
    ./symfony guard:create-user [somebody@example.com] [username] [password]
    ./symfony guard:add-group [username] admin

