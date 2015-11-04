<?php
namespace App\Library\Html;

class Assets {
    static $_instance;
    public $_CSSlinks = array();
    public $_JSLinks = array();
    public $_JSLinksTop = array();
    public $_InlineJS = "";
    public $_Metas = array();

    static function addMetaTag(Meta $meta)
    {
        $assets = self::$_instance;
        if (!$assets) {
            $assets = new Assets();
        }

        $assets->_Metas[] = $meta;

        self::$_instance = $assets;
    }

    static function addLink(Link $link)
    {
        $assets = self::$_instance;

        if (!$assets) {
            $assets = new Assets();
        }

        if ($link->_linktype == Link::TYPE_CSS) {
            $assets->_CSSlinks[] = $link;
        } else {
            if ($link->_renderpos == "head") {
                $assets->_JSLinksTop[] = $link;
            } else {
                $assets->_JSLinks[] = $link;
            }
        }

        self::$_instance = $assets;
    }

    static function renderMetaData()
    {
        $assets = self::$_instance;
        $buf = "";
        foreach($assets->_Metas as $meta)
        {
            $buf .= $meta->Render();
        }

        return $buf;
    }

    static function renderLinks($pos = "")
    {
        $assets = self::$_instance;

        $buf = "";
        if ($pos === "top") {
            foreach ($assets->_CSSlinks as $lnk)
            {
                $buf .= $lnk->render() ."\n";
            }
            foreach ($assets->_JSLinksTop as $lnk)
            {
                $buf .= $lnk->render() ."\n";
            }
        } else {
            foreach ($assets->_JSLinks as $lnk)
            {
                $buf .= $lnk->render() ."\n";
            }
        }

        return $buf;
    }
}

