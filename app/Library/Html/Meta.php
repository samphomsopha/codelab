<?php
namespace App\Library\Html;

class Meta
{
    protected $_name;
    protected $_content;
    protected $_scheme;
    protected $_charset;
    protected $_httpequiv;


    static function Tag($name, $content, $options = array())
    {
        $meta = new Meta();
        $meta->_name = $name;
        $meta->_content = $content;

        $meta->_charset = !empty($options['charset']) ? $options['charset'] : null;
        $meta->_scheme = !empty($options['scheme']) ? $options['scheme'] : null;
        $meta->_httpequiv = !empty($options['httpequiv']) ? $options['httpequiv'] : null;

        return $meta;
    }

    public function Render()
    {
        $buf = "<meta";

        if ($this->_name) {
            $buf .= ' name="' . $this->_name . '"';
        }

        if ($this->_content) {
            $buf .= ' content="' . $this->_content . '"';
        }

        if ($this->_charset) {
            $buf .= ' charset="' . $this->_charset . '"';
        }

        if ($this->_httpequiv) {
            $buf .= ' http-equiv="' . $this->_httpequiv . '"';
        }

        if ($this->_scheme) {
            $buf .= ' scheme="' . $this->_scheme . '"';
        }

        $buf .= "/>\n";

        return $buf;
    }
}