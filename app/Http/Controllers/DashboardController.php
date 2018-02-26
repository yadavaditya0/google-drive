<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Googl;
use Carbon\Carbon;
use App\File;

class DashboardController extends Controller
{
    private $client;
    private $drive;

    public function __construct(Request $request, Googl $googl)
    {
        $this->client = $googl->client();
        $this->client->setAccessToken(session('token'));
        $this->drive = $googl->drive($this->client);
    }

     /**
     * Saving retrived files
     *
     * @return void
     */
    public function index()
    {
        $result = [];
        $pageToken = NULL;

        $three_months_ago = Carbon::now()->subMonths(3)->toRfc3339String();

        do {
            try {
                $parameters = [
                    //getting viewed/modified files in last 3 months
                    'q' => "viewedByMeTime >= '$three_months_ago' or modifiedTime >= '$three_months_ago'",
                    //ordered by file modified time
                    'orderBy' => 'modifiedTime',
                    //fields we like to get
                    'fields' => 'nextPageToken, files(id, name, modifiedTime, iconLink, webViewLink, webContentLink, size, mimeType)',
                ];

                if ($pageToken) {
                    $parameters['pageToken'] = $pageToken;
                }

                $result = $this->drive->files->listFiles($parameters);
                $files = $result->files;

                $pageToken = $result->getNextPageToken();

            } catch (Exception $e) {
                return redirect('/files')->with('message',
                    [
                        'type' => 'error',
                        'text' => 'Something went wrong while trying to list the files'
                    ]
                );
                $pageToken = NULL;
            }
        } while ($pageToken);

        if($files):
            foreach ($files as $file) :
                //check if file is not shortcut else 0 return
                if(!empty($file->size)) :
                    $file_size = round($file->size/1024, 2);
                else :
                    $file_size = 0;
                endif;
                
                //check if file type is binary else shortcut return
                if(!empty($file->webContentLink)) :
                    $file_download_link = $file->webContentLink;
                else :
                    $file_download_link = 'N/A';
                endif;

                //check if file already exsist
                $checkFile = File::where('file_id', $file->id)->first();
                if($checkFile) :
                    //if exsist all the fields updated except file_id
                    $checkFile->file_icon_link = $file->iconLink;
                    $checkFile->file_name = $file->name;
                    $checkFile->file_type = $file->mimeType;
                    $checkFile->file_size =$file_size;
                    $checkFile->file_view_link = $file->webViewLink;
                    $checkFile->file_download_link = $file_download_link;
                    $checkFile->save();
                else :
                    //else a new file inserted
                    $file_metadata = new File;
                    $file_metadata->file_id = $file->id;
                    $file_metadata->file_icon_link = $file->iconLink;
                    $file_metadata->file_name = $file->name;
                    $file_metadata->file_type = $file->mimeType;
                    $file_metadata->file_size =$file_size;
                    $file_metadata->file_view_link = $file->webViewLink;
                    $file_metadata->file_download_link = $file_download_link;
                    $file_metadata->save();
                endif;
            endforeach;
        endif;
        return redirect('filelist');
    }
    
    /**
     * Listing all saved files
     *
     * @return $files 
     * @return $name
     */
    public function fileList()
    {
        //get
        $files = File::paginate(10);
        $name = session('first_name').' '.session('last_name');
        return view('dashboard', [ 'files' => $files, 'name' => $name ]);
    }
}
