yii-imagesHolder
================

```
git submodule add git@github.com:alari/yii-imagesHolder.git protected/modules/imagesHolder
git submodule add git@github.com:alari/yii-imagine.git protected/extensions/imagine
```

```
    'import' => array(
        // For imagesHolder
        'application.modules.imagesHolder.models.*',

    'modules' => array(
            'imagesHolder' => array(
                'types' => array(
                    'materialSlides' => array(
                        'maxNum' => 0,
                        'preview' => 'tiny',
                        'default' => 'big',
                        'sizes' => array(
                            "big" => "800x600",
                            "tiny" => "120x120 thumb",
                            "partial" => "200x200 crop"
                        )
                    )
                )
            ),
    )
```


`./yiic migrate --migrationPath=imagesHolder.migrations`