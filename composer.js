{
    "name": "ivoglent/yii2-media-manager",
    "description": "Simple media manager for the Yii framework",
    "keywords": [
        "ivoglent",
        "yii",
        "yii2",
        "yii 2",
        "photo",
        "upload"
    ],
    "type": "yii2-extension",
    "license": "BSD-3-Clause",
    "homepage": "https://github.com/ivoglent/yii2-media-manager",
    "authors": [
        {
            "name": "Ivoglent Nguyen",
            "email": "ivoglent@gmail.com",
            "role": "Developer"
        }
    ],
    "require": {
        "yiisoft/yii2": "~2.0.0",
        "yiisoft/yii2-bootstrap": "~2.0.0"
    },
    "require-dev": {
        "phpunit/phpunit": "~4.0"
    },
    "autoload": {
        "psr-4": {
            "ivoglent\\media\\manager\\": "src"
        }
    },
    "config": {
        "fxp-asset": {
            "installer-paths": {
                "npm-asset-library": "vendor/npm",
                "bower-asset-library": "vendor/bower"
            }
        }
    },
    "extra": {
        "branch-alias": {
            "dev-master": "1.0-dev"
        }
    }
}
