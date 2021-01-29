<?php

namespace App\Tools;

use Illuminate\Support\Facades\Request;

class CustomHelpers
{
    public static function backtraceOne()
    {


        echo 'Drop from function: <b> ' . debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['function'] . '</b></br>';
        echo 'called from: <b> ' . debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['file'] . '</b> line: <b> ' . debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['line'] . '</b></br>';
    }

    public static function consoleDrop(mixed $var, string $title = "")
    {

        echo '<h3>' . $title . '</h3>';
        CustomHelpers::backtraceOne();

        echo '<pre>';
        print_r($var);
        die();
    }
    public static function consoleDropUser()
    {

        CustomHelpers::backtraceOne();

        echo '<pre><h3>User</h3>';
        print_r(Request::user()->id);
        echo '<br>';
        print_r(Request::user()->name);
        echo '<br>';
        print_r(Request::user()->email);
        echo '<h3>User roles</h3>';
        print_r(Request::user()->roles->toJson(JSON_PRETTY_PRINT));
        echo '<h3>User companies</h3>';
        print_r(Request::user()->companies->toJson(JSON_PRETTY_PRINT));
        echo '<h3>User chapters</h3>';
        print_r(Request::user()->chapters->toJson(JSON_PRETTY_PRINT));

        die();
    }
}
