<?php
namespace App\Traits;

use Illuminate\Pipeline\Pipeline;

trait Pipeable{
    protected $pipeableThrough = [];

    public function pipeable(){
        return $this->pipeableThrough;
    }

    public static function pipe($pipeableObject = null){
        if(empty($pipeableObject)){
            $pipeableObject = self::query();
        }
        $self = new static;
        return app(Pipeline::class)
            ->send($pipeableObject)
            ->through($self->pipeable())
            ->thenReturn();
    }
}