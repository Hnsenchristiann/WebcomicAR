<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\ChapterPreview;
use App\Models\Comic;
use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CreateContent extends Command
{
    private $comic, $sceneStub;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'we add content this way because creating backend would take too long';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contentProfilePath = storage_path('content/profile-pictures/alan_moore.jpg');
        $storageProfilePath = public_path('storage/media/authors/alan_moore.jpg');
        File::copy($contentProfilePath, $storageProfilePath);
        //Create author
        $author = Author::create([
            'name' => 'Raiyan Laksamana',
            'email' => 'raiyan@visi8.com',
            'description' => 'CEO of Visi8',
            'social_media_links' => '[]',
            'profile_picture_url' => '/storage/media/authors/alan_moore.jpg'
        ]);

        $contentProfilePath = storage_path('content/covers/kara.jpg');
        $storageProfilePath = public_path('storage/media/covers/kara.jpg');
        File::copy($contentProfilePath, $storageProfilePath);
        //Create comic
        $this->comic = Comic::create([
            'title' => 'Kara Guardian of Realms',
            'description' => 'To be added later',
            'tags' => json_encode(['visi8-original', 'kids']),
            'genres' => json_encode(['fantasy', 'sci-fi']),
            'price' => 10000,
            'cover_url' => '/storage/media/covers/kara.jpg',
            'release_date' => now()
        ]);
        $this->comic->authors()->sync([$author->id]);

        $this->sceneStub = file_get_contents(base_path('storage/content/stubs/Scene.html.stub'));
        $this->createChapter(0);
        $this->createChapter(1);
        $this->createChapter(2);
        $this->createChapter(3);
        // $chapterZero = storage_path('content/comics/cpt0/');
        // $cptZeroFiles = File::files($chapterZero);
        // $cptZeroSectionCount = 0;
        // foreach($cptZeroFiles as $file){
        //     $pathName = $file->getPathname();
        //     $publicFileName = '0_' . $file->getFilename();
        //     $publicPathName = public_path('storage/media/comics/' . $publicFileName);
        //     File::copy($pathName, $publicPathName);
        //     $pageObj = [
        //         'page_number' => $cptZeroSectionCount,
        //         'section' => $cptZeroSectionCount,
        //         'config' => 'figureoutlater',
        //         'comic_id' => $this->comic->id,
        //         'image_url' => '/storage/media/comics/' . $publicFileName
        //     ];
        //     $fileNameArray = explode('.', $file->getFilename());
        //     if (strpos($fileNameArray[0], '_AR') !== false) {
        //         $actualName = explode('_', $fileNameArray[0]);
        //         $pageObj['scene'] = str_replace('%%model_url%%', 'https://insert url here/0_' . $actualName[0] . '.glb', str_replace('%%id%%', '0_' . $actualName[0], $this->sceneStub));
        //     }

        //     $cptZeroSectionCount++;
        // }
        // $cptZeroPreviewStorage = storage_path('content/previews/0.jpg');
        // $cptZeroPreviewPublic = public_path('storage/media/previews/0.jpg');
        // File::copy($cptZeroPreviewStorage, $cptZeroPreviewPublic);
        // $prev = ChapterPreview::create([
        //     'image_url' => '/storage/media/previews/0.jpg',
        //     'comic_id' => $this->comic->id,
        //     'chapter' => 0
        // ]);

        return 0;
    }

    private function createChapter($cpt){
        $chapterZero = storage_path('content/comics/cpt' . $cpt . '/');
        $cptZeroFiles = File::files($chapterZero);
        $cptZeroSectionCount = 0;
        foreach($cptZeroFiles as $file){
            $pathName = $file->getPathname();
            $publicFileName = $cpt . '_' . $file->getFilename();
            $publicPathName = public_path('storage/media/comics/' . $publicFileName);
            File::copy($pathName, $publicPathName);
            $fileNameArray = explode('.', $file->getFilename());
            $actualName = explode('_', $fileNameArray[0]);
            $pageObj = [
                'page_number' => $cptZeroSectionCount,
                'section' => (int)$actualName[0],
                'config' => 'figureoutlater',
                'comic_id' => $this->comic->id,
                'image_url' => '/storage/media/comics/' . $publicFileName,
                'chapter' => $cpt
            ];
            if (strpos($fileNameArray[0], '_AR') !== false) {
                $config = [
                    'entityScale' => [2, 2, 2],
                    'cameraPosition' => [0, 2, 3],
                    'modelUrl' => 'https://visi8-webcomic.s3.ap-southeast-1.amazonaws.com/' . $cpt . '_' . $actualName[0] . '.glb',
                    'id' => $cpt . '_' . $actualName[0]
                ];
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
                $pageObj['scene'] = $this->substringsReplace($this->sceneStub, $replaceArr);
                $pageObj['config'] = json_encode($config);
                // $pageObj['scene'] = str_replace('%%model_url%%', 'https://visi8-webcomic.s3.ap-southeast-1.amazonaws.com/' . $cpt . '_' . $actualName[0] . '.glb', str_replace('%%id%%', $cpt . '_' . $actualName[0], $this->sceneStub));
            }
            Page::create($pageObj);

            $cptZeroSectionCount++;
        }
        $cptZeroPreviewStorage = storage_path('content/previews/' . $cpt . '.jpg');
        $cptZeroPreviewPublic = public_path('storage/media/previews/' . $cpt . '.jpg');
        File::copy($cptZeroPreviewStorage, $cptZeroPreviewPublic);
        $prev = ChapterPreview::create([
            'image_url' => '/storage/media/previews/' . $cpt . '.jpg',
            'comic_id' => $this->comic->id,
            'chapter' => $cpt,
            'release_date' => now()
        ]);
    }

    private function substringsReplace($str, $arr){
        $retVal = $str;
        foreach($arr as $search => $replace){
            $retVal = str_replace($search, $replace, $retVal);
        }
        return $retVal;
    }
}
