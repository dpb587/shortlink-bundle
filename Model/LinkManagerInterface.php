<?php

namespace DPB\Bundle\ShortlinkBundle\Model;

interface LinkManagerInterface
{
    function create($url);
    function createUnique($url);

    function lookup($code);
    function lookupUrl($url);
}
