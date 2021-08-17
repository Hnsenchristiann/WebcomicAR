<?php

namespace App\Models;

use App\Filters\Get;
use App\Traits\Pipeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use Pipeable;
    protected $guarded = [];

    public function pipeable(){
        return [
            Get::class
        ];
    }

    public function comic(){
        return $this->belongsTo(Comic::class);
    }

    public function bookmarked(){
        return $this->belongsToMany(User::class);
    }

    public function setCameraLocation($x, $y, $z){
        $configArr = json_decode($this->config, true);
        if(empty($configArr)) return;

        $configArr['cameraPosition'] = [$x, $y, $z];
        $this->config = json_encode($configArr);
        $this->save();
        $this->rebuildScene();
    }

    public function setSceneScale($x, $y, $z){
        $configArr = json_decode($this->config, true);
        if(empty($configArr)) return;

        $configArr['entityScale'] = [$x, $y, $z];
        $this->config = json_encode($configArr);
        $this->save();
        $this->rebuildScene();
    }

    private function rebuildScene(){
        $sceneStub = file_get_contents(base_path('storage/content/stubs/Scene.html.stub'));
        $config = json_decode($this->config, true);
        $replaceArr = [
            '%%model_url%%' => $config['modelUrl'],
            '%%id%%' => $config['id'],
            '%%entity_scale_x%%' => $config['entityScale'][0],
            '%%entity_scale_y%%' => $config['entityScale'][1],
            '%%entity_scale_z%%' => $config['entityScale'][2],
            '%%camera_position_x%%' => $config['cameraPosition'][0],
            '%%camera_position_y%%' => $config['cameraPosition'][1],
            '%%camera_position_z%%' => $config['cameraPosition'][2],
        ];
        $this->scene = str_replace(array_keys($replaceArr), array_values($replaceArr), $sceneStub);
        $this->save();
    }
}
