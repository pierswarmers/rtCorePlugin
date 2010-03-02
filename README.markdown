= gnCorePlugin =

The `gnCorePlugin` is the cetral and only required-by-all plugin for the Gumnut suite. It contains a set of common and required pieces, around which, all other Gumnut plugins are built.

In summary these core features include:

 * Search
 * Helpers
 * Models, and;
 * A selection of modules.

== Pre-Installation ==

You'll need to have an active Symfony 1.4 project before getting started with the installation.

[code]
mkdir myproject
cd myproject
symfony1.4 generate:project myproject
[/code]

You'll also need to configure a database...

[code]
mysqladmin -uroot -pmyDbPassword create myproject_test
[/code]

...and make sure the account settings are reflected in `config/databases.yml`:

[code]
all:
  doctrine:
    class: sfDoctrineDatabase
    param:
      dsn: 'mysql:host=localhost;dbname=myproject'
      username: root
      password: myDbPassword
[/code]

== Installation == 

1. Download the `gnCorePlugin` into you plugins directory along with the followong plugins:

[code]
svn co http://svn.symfony-project.com/plugins/sfDoctrineActAsTaggablePlugin/trunk/ plugins/sfDoctrineActAsTaggablePlugin
svn co http://svn.symfony-project.com/plugins/sfThumbnailPlugin/trunk/ plugins/sfThumbnailPlugin
svn co http://svn.symfony-project.com/plugins/sfDoctrineGuardPlugin/trunk/ plugins/sfDoctrineGuardPlugin
svn co http://svn.symfony-project.com/plugins/sfFormExtraPlugin/branches/1.3/ plugins/sfFormExtraPlugin
svn co http://svn.symfony-project.com/plugins/sfGeshiPlugin/trunk plugins/sfGeshiPlugin plugins/sfGeshiPlugin
[/code]

If you intend to use othe Gumnut plugins (gnBlogPlugin, gnBlogPlugin or gnSitePlugin), download them now.

2. Enable the plugin in your `ProjectConfiguration.class.php`

[code]
    // The enabled plugins call will look something like this.
    $this->enablePlugins(
            'gnCorePlugin',
            'gnBlogPlugin',     // optional
            'gnSitePlugin',     // optional
            'gnWikiPlugin',     // optional
            'sfDoctrinePlugin',
            'sfDoctrineActAsTaggablePlugin',
            'sfDoctrineGuardPlugin',
            'sfGeshiPlugin'
            );
[/code]

3. You need a frontend application, if you don't already have one:

[code]
./symfony generate:app frontend
[/code]

4. Enable the required modules in your fontend `apps/frontend/config/app.yml`:

[code]
    # Enable the plugin modules
    enabled_modules:
      - gnSearch
      - gnGuardAuth
      - gnGuardForgotPassword
      - gnGuardRegister
[/code]

5. While we're here, lets set up the email configuration in `factories.yml`:

[code]
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
[/code]

6. You will now need to run a complete build on your project:

[code]
./symfony doctrine:build --all
./symfony cc
./symfony plugin:publish-assets
[/code]

7. You're done!

== Wrap-up ==

You'll probably want to create a user now. Its simple to do from the cli using the following task:

[code]
./symfony guard:create-user somebody@example.com username password
[/code]