# rtCorePlugin

The `rtCorePlugin` is the cetral and only required-by-all plugin for the Reditype suite. It contains a set of common and required pieces, around which, all other Reditype plugins are built.

In summary these core features include:

 * Search
 * Helpers
 * Models, and;
 * A selection of modules.

## Pre-Installation

You'll need to have an active Symfony 1.4 project before getting started with the installation.

    mkdir myproject
    cd myproject
    symfony1.4 generate:project myproject

You'll also need to configure a database...

    mysqladmin -uroot -pmyDbPassword create myproject_test

...and make sure the account settings are reflected in `config/databases.yml`:

    all:
      doctrine:
        class: sfDoctrineDatabase
        param:
          dsn: 'mysql:host=localhost;dbname=myproject'
          username: root
          password: myDbPassword

## Installation

1. Download the `rtCorePlugin` into you plugins directory along with the followong plugins:

        svn co http://svn.symfony-project.com/plugins/sfDoctrineActAsTaggablePlugin/trunk/ plugins/sfDoctrineActAsTaggablePlugin
        svn co http://svn.symfony-project.com/plugins/sfThumbnailPlugin/trunk/ plugins/sfThumbnailPlugin
        svn co http://svn.symfony-project.com/plugins/sfDoctrineGuardPlugin/trunk/ plugins/sfDoctrineGuardPlugin
        svn co http://svn.symfony-project.com/plugins/sfFormExtraPlugin/branches/1.3/ plugins/sfFormExtraPlugin
        svn co http://svn.symfony-project.com/plugins/sfGeshiPlugin/trunk plugins/sfGeshiPlugin

    **Note:** If you intend to use othe Reditype plugins (rtBlogPlugin, rtBlogPlugin or rtSitePlugin), download them now.

2. Enable the plugin in your `ProjectConfiguration.class.php`, The enabled plugins call will look something like this:

        $this->enablePlugins(
          'rtCorePlugin',
          'rtBlogPlugin',     // optional
          'rtSitePlugin',     // optional
          'rtWikiPlugin',     // optional
          'sfDoctrinePlugin',
          'sfDoctrineActAsTaggablePlugin',
          'sfFormExtraPlugin',
          'sfDoctrineGuardPlugin',
          'sfThumbnailPlugin',
          'sfGeshiPlugin'
        );

3. You need a frontend application, if you don't already have one:

        ./symfony generate:app frontend

4. Enable the required modules in your fontend `apps/frontend/config/settings.yml`:

            enabled_modules:
              - rtAsset
              - rtSearch
              - rtGuardAuth
              - rtGuardForgotPassword
              - rtGuardRegister
              - rtWikiPage

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

6. Symfony will now need to be told how user authentication should be handled.

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

7. You will now need to run a complete build on your project:

        ./symfony doctrine:build --all
        ./symfony cc
        ./symfony plugin:publish-assets

8. You're done!

## Wrap-up

You'll probably want to create a user now. Its simple to do from the cli using the following task:

    ./symfony guard:create-user somebody@example.com username password

