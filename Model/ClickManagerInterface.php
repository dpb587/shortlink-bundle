<?php

namespace DPB\Bundle\ShortlinkBundle\Model;

use Symfony\Component\HttpFoundation\Request;
use DPB\Bundle\ShortlinkBundle\Entity\Link;

interface ClickManagerInterface
{
    function record(Request $request, Link $link);
}
