<?php

namespace Theme\Main\Http\Controllers;

use Platform\Theme\Http\Controllers\PublicController;
use Theme;

class MainController extends PublicController
{
    public function index()
    {
        return Theme::scope('index')->render();
    }
}
