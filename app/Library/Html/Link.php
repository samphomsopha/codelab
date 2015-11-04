<?php
namespace App\Library\Html;

class Link {

    public $_linktype;
    public $_charset;
    public $_crossorigin;
    public $_href;
    public $_hreflang;
    public $_media;
    public $_rel;
    public $_sizes;
    public $_mediatype;
    public $_async;
    public $_defer;
    public $_xmlspace;
    public $_src;
    public $_renderpos;

    const TYPE_CSS = 'css';
    const TYPE_JS = 'javascript';

    public function __construct($type)
    {
        $this->_linktype = $type;
    }

    public static function Css($href, $options = array())
    {
        $link = new Link(self::TYPE_CSS);
        $link->_href = $href;
        $link->_rel = "stylesheet";
        $link->_mediatype = "text/css";

        $link->_charset = !empty($options['charset']) ? $options['charset'] : null;
        $link->_crossorigin = !empty($options['crossorigin']) ? $options['crossorigin'] : null;
        $link->_hreflang = !empty($options['hreflang']) ? $options['hreflang'] : null;
        $link->_media = !empty($options['media']) ? $options['media'] : null;
        $link->_sizes = !empty($options['sizes']) ? $options['sizes'] : null;
        $link->_mediatype = !empty($options['mediatype']) ? $options['mediatype'] : null;
        $link->_renderpos = "top";

        return $link;
    }

    public static function Script($href, $options = array())
    {
        $link = new Link(self::TYPE_JS);
        $link->_src = $href;

        $link->_async = !empty($options['async']) ? $options['async'] : null;
        $link->_charset = !empty($options['charset']) ? $options['charset'] : null;
        $link->_mediatype = !empty($options['mediatype']) ? $options['mediatype'] : null;
        $link->_defer = !empty($options['defer']) ? $options['defer'] : null;
        $link->_xmlspace = !empty($options['xmlspace']) ? $options['xmlspace'] : null;
        $link->_renderpos = !empty($options['renderpos']) ? $options['renderpos'] : 'bottom';

        return $link;
    }

    public function render()
    {
        $lnk = "<";
        $ending = ">";
        if ($this->_linktype === self::TYPE_CSS) {
            $lnk = "<link";
            $ending = "/>";
        } else {
            $lnk = "<script";
            $ending = "></script>";
        }

        if ($this->_rel) {
            $lnk .= ' rel="' . $this->_rel . '"';
        }

        if ($this->_src) {
            $lnk .= ' src="' . $this->_src . '"';
        }

        if ($this->_href) {
            $lnk .= ' href="' . $this->_href . '"';
        }

        if ($this->_mediatype) {
            $lnk .= ' type="' . $this->_mediatype . '"';
        }

        if ($this->_charset) {
            $lnk .= ' charset="' . $this->_charset . '"';
        }

        if ($this->_crossorigin) {
            $lnk .= ' crossorigin="' . $this->_crossorigin . '"';
        }

        if ($this->_hreflang) {
            $lnk .= ' hreflang="' . $this->_hreflang . '"';
        }

        if ($this->_media) {
            $lnk .= ' media="' . $this->_media . '"';
        }

        if ($this->_sizes) {
            $lnk .= ' sizes="' . $this->_sizes . '"';
        }

        if ($this->_async) {
            $lnk .= ' async="' . $this->_async . '"';
        }

        if ($this->_defer) {
            $lnk .= ' defer="' . $this->_defer . '"';
        }

        if ($this->_xmlspace) {
            $lnk .= ' xml:space="' . $this->_xmlspace . '"';
        }

        $lnk .= $ending;

        return $lnk;
    }
}
