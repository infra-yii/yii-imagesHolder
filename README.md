yii-imagesHolder
================

`git submodule add git@github.com:alari/yii-imagesHolder.git protected/modules/imagesHolder`

```
    'components' => array(
            'image' => array(
                'class' => 'imagesHolder.extensions.image.CImageComponent',
                // GD or ImageMagick
                'driver' => 'GD',
            ),
    ),

    'modules' => array(
            'imagesHolder' => array(
                'types' => array(
                    'materialSlides' => array(
                        'maxNum' => 0,
                        'preview' => 'tiny',
                        'default' => 'big',
                        'sizes' => array(
                            "big" => "800x600",
                            "tiny" => "120x120"
                        )
                    )
                )
            ),
    )
```


`./yiic migrate --migrationPath=imagesHolder.migrations`