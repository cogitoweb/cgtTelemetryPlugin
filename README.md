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

  * Rebuild your model

        $ symfony propel:build-model
        $ symfony propel:build-sql
        $ symfony propel:build-forms
        $ symfony propel:build-filters

  * Update your database

        Create the new table by using the generated SQL statements in `data/sql/plugins.cgtTelemetryPlugin.lib.model.schema.sql`

  * Enable the modules in your `settings.yml`

        [php]
            all:
              .settings:
                enabled_modules:      [..., "cgtTelemetry"]

  * Clear cache

        $ symfony cc