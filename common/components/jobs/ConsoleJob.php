<?php
namespace common\queues;

use yii\base\BaseObject;
use yii\helpers\Console;
use yii\log\Logger;

class ConsoleJob extends BaseObject implements \yii\queue\JobInterface
{
    public $command;
    
    public function execute($queue)
    {
        $line = exec($this->command, $out, $return_var);
        if ($return_var != 0) {
            Console::error('common error: error_code ' . $return_var . ' ' . $line);
            \Yii::getLogger()->log('error ' . $line, Logger::LEVEL_ERROR);
        }
       Console::output(join("\n", $out));
    }
}
