<?php

namespace Rockschtar\WordPress\Settings\Enums;

enum InputType
{
    case text;
    case number;
    case color;
    case date;
    case email;
    case password;
    case url;
}
