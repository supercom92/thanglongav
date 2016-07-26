<?php
namespace Webapp\Backend\Models;
class ConfigNotecircle extends BaseModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $keys;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $contents;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'config_notecircle';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ConfigNotecircle[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ConfigNotecircle
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
