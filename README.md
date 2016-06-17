cgtTelemetryPlugin
==================

The `cgtTelemetryPlugin` is a symfony 1.4 plugin that provides the data
necessary to CogitowebTelemetryBundle to build statistics.

Installation
------------

  * Install the plugin

    $ cd plugins/
		$ git clone https://github.com/cogitoweb/cgtTelemetryPlugin.git

  * Enable the plugin

        Add "cgtTelemetryPlugin" in "config/ProjectConfiguration.class.php".

  * Update your database

        Create the new table by using the generated SQL statements in `data/sql/plugins.cgtTelemetryPlugin.lib.model.schema.sql`

  * Enable the modules in your `settings.yml`

        [php]
            all:
              .settings:
                enabled_modules:      [..., 'cgtTelemetry', 'cgt_telemetry']

  * Clear cache

        $ symfony cc