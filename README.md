yii-imagesHolder
================

Motivation
----------------

You almost always need to handle and store images. Product photos, avatars, promo pictures, whatever.

Why should you code again? This `Yii` module allows to add `ImagesHolder` behaviour (with several image sizes, good crop+resize/thumb generation) just with a few lines.

Usage
----------------

0) Create relation for your model to `ImagesHolder` class, e.g.:

```php
	public function up()
	{
        $this->addColumn("{{static_page}}", "pic_holder_id", "int");
        $this->addForeignKey("page_pic", "{{static_page}}", "pic_holder_id", "{{images_holder}}", "id");
        $this->addColumn("{{static_page}}", "list_holder_id", "int");
        $this->addForeignKey("page_list", "{{static_page}}", "list_holder_id", "{{images_holder}}", "id");
	}
```

1) Implement `ImagesHolderModel` interface on your model class and add `ImagesHolderBehaviour`:

```php

class StaticPage extends BaseStaticPage implements ImagesHolderModel {

        #...

    /**
     * @return array
     */
    public function imageHolders()
    {
        return array(
            "list_holder_id" => "list",
            "pic_holder_id" => "pic"
        );
    }

        #...

        # Don't forget to note your relations in relations() and rules() methods (this could be done with giix)

    public function rules() {
        $rules = parent::rules();
        $rules [] = array('pic_holder_id, list_holder_id', 'default', 'setOnEmpty' => true, 'value' => null);
        return $rules;
    }

    public function relations() {
        $relations = parent::relations();
        $relations['listHolder'] = array(self::BELONGS_TO, 'ImagesHolder', 'list_holder_id');
        $relations['picHolder'] = array(self::BELONGS_TO, 'ImagesHolder', 'pic_holder_id');
        return $relations;
    }

        # And adding behaviour

    public function behaviors() {
        return array(
            'imagesHolder' => array(
                'class' => 'imagesHolder.models.ImagesHolderBehavior'
            )
        );
    }
}
```

2) Modify your `_form.php` partial template (or any other form template where you wish to save images):

```php
// images holder integration
$modelRefl = new ReflectionClass($model);
$imageHolders = array();
if($modelRefl->implementsInterface("ImagesHolderModel")) {
    foreach($model->imageHolders() as $h=>$t) {
        $h = str_replace(" ", "", ucwords(str_replace("_", " ", substr($h, 0, -3))));
        $h[0] = strtolower($h[0]);
        $imageHolders[$h] = $t;
    }
}
?>

 <?if(count($imageHolders)){?>
    <fieldset>
        <?foreach($imageHolders as $field=>$type) $this->widget("imagesHolder.widgets.heldImages.EditImages", array("holder"=>(($model && $model->$field) ? $model->$field : $type))) ?>
    </fieldset>
 <?}?>
```

3) Use your images holder in views:

```php
<? $this->widget("imagesHolder.widgets.heldImages.HeldImages", array("holder" => $model->listHolder, "size" => "tiny")) ?>
```

You may (and probably should) use your own widgets to render held images. `ImagesHolder->images` is an array of `HeldImage` objects:

```php
class HeldImage {
    public function getSrc($size);
    #...
}
```

Sizes are got from the config.

Installation
----------------

```sh
git submodule add git@github.com:alari/yii-imagesHolder.git protected/modules/imagesHolder
git submodule add git@github.com:alari/yii-imagine.git protected/extensions/imagine
```

```php
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