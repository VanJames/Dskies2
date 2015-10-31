<?php

class MyCConsoleCommand extends CConsoleCommand {

    public $lock_fp;

    public function getLock($filename, $args) {
        $path = dirname(__FILE__) . '/../' . 'lock/';

        if (preg_match("/(\w+)Command/", $filename, $matchs)) {
            $arg_str = implode("_", $args);
            $command = strtolower($matchs[1]);
            $fileName = "$command$arg_str.txt";
            $this->lock_fp = fopen("$path$fileName", "w+");
            return flock($this->lock_fp, LOCK_EX | LOCK_NB);
        }

        return false;
    }

}

?>