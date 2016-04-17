default:
    autoload: [ %paths.base%/contexts ]

    extensions:
        Behat\MinkExtension:
           # base_url: http://localhost/starwarsevents/web/app_dev.php
            base_url: https://en.wikipedia.org
            goutte: ~
            selenium2: ~

    suites:
        default:
            contexts:
                - FeatureContext
                - Behat\MinkExtension\Context\MinkContext

       # events_admin-module:
        #    contexts:
         #       - FeatureContext
          #      - Behat\MinkExtension\Context\MinkContext
        commands:
            paths: [ %paths.base%/features/commands ]
            contexts:
                - FeatureContextLs
                - Behat\MinkExtension\Context\MinkContext

        web:
            paths: [ %paths.base%/features/web ]
            contexts:
                - SearchWikiContext
                - Behat\MinkExtension\Context\MinkContext