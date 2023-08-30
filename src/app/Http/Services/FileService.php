<?php
namespace App\Http\Services;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
class FileService 
{
  

    /**
     * store a file & image
     *
     * @param  $file
     * @param string $location
     * @param string $size
     * @param string $removeFile
     * @param string $name
     * @return array
     */
    public static function storeFile($file , string $location , string $size = null , string $removeFile = null ,string $name = null ): array 
    {

        $name = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $imagePath = $location . '/' .$name ;
        $status = true;
        $message = translate("File Uploaded Successfully");
        $disk = 'local';
    
        if($removeFile){
            (new self())->unlink($location ,$removeFile) ;    
        }
      
        if(site_settings('storage') == 's3'){
            $disk = 's3';
     
            (new self())->awsConfig();
            $path = \Storage::disk('s3')->putFileAs(
                $location ,
                $file,
                $name 
            );
        }
        elseif(site_settings('storage') == 'ftp'){
            $disk = 'ftp';
            (new self())->ftpConfig();
            $path = \Storage::disk('ftp')->putFileAs(
                $location ,
                $file,
                $name 
            );
        }
        else{

            $name = str_replace("{{prefix}}",'local_',$name);
            if (!file_exists($location)) {
                mkdir($location, 0755, true);
            }

            if(substr($file->getMimeType(), 0, 5) == 'image') {

                $image = Image::make(file_get_contents($file));
                if (isset($size)) {
                    
                    list($width, $height) = explode('x', strtolower($size));
                    $image->resize($width, $height,function ($constraint) {
                        $constraint->aspectRatio();
                    });
                   
                }
                $image->save($imagePath);
            }
            else{
                $file->move($location,$name);
            }
        }

        return [
            'status'=> $status,
            'message'=> $message,
            'name' => $name,
            'disk' => $disk ,
        ];
   
    }



    /**
     * Unlink File Or Image 
     *
     * @param string $location
     * @param [type] $image
     * @param string|null $disk
     * @return void
     */
    public function unlink(string $location ,string $image = null , string $disk = null) :void{

        $this->awsConfig();
        $this->ftpConfig();
     
        try {
            if(Storage::disk('s3')->exists($location . '/' . $image)){
                Storage::disk('s3')->delete($location . '/' . $image);
            }
            if(Storage::disk('ftp')->exists($location . '/' . $image)){
                Storage::disk('ftp')->delete($location . '/' . $image);
            }
            if (file_exists($location . '/' . $image) && is_file($location . '/' . $image)) {
                @unlink($location . '/' . $image);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
       


    }


    /**
     * aws configuration 
     *
     * @return void
     */
    public function awsConfig(){
        $aws_config = json_decode(site_settings('aws_s3'),true);
        config(
            [
                'filesystems.disks.s3.key' => $aws_config['s3_key'],
                'filesystems.disks.s3.secret' => $aws_config['s3_secret'],
                'filesystems.disks.s3.region' => $aws_config['s3_region'],
                'filesystems.disks.s3.bucket' => $aws_config['s3_bucket'],
                'filesystems.disks.s3.use_path_style_endpoint' => false,
            ]
        );
    }


    /**
     * ftp configuration 
     *
     * @return void
     */
    public function ftpConfig() :void{

        $ftp_config = json_decode(site_settings('ftp'),true);
        config(
            [
                'filesystems.disks.ftp.host' => $ftp_config['host'],
                'filesystems.disks.ftp.username' => $ftp_config['user_name'],
                'filesystems.disks.ftp.password' => $ftp_config['password'],
                'filesystems.disks.ftp.port' => (int) $ftp_config['port'],
                'filesystems.disks.ftp.root' => $ftp_config['root']
            ]
        );

    }



    /**
     * get image url
     *
     * @param string|null $image
     * @param string $disk
     * @param string|null $size
     * @return void
     */
    public  static function getImageUrl(string  $image = null, string $disk = null ,string $size = null)
    {
        $image_url = asset('assets/images/default.jpg');
 
        try {
            if($disk == 's3'){
                (new self())->awsConfig();
                $file = \Storage::disk('s3')->url($image);
                if((new self())->check_file( $file)){
                    $image_url  = $file;
                } 
            }
            elseif($disk == 'ftp'){
                (new self())->ftpConfig();
                $file = \Storage::disk('ftp')->url($image);
                if((new self())->check_file( $file)){
                    $image_url  = $file;
                } 
            }
            else{
                if (file_exists($image) && is_file($image)) {
                    $image_url =  asset($image);
                }
            }

        } catch (\Throwable $th) {
            
        }
        return  $image_url;          
    }
    

    /**
     * Check if file exists or not
     *
     * @param string $url
     * @return boolean
     */
    public static function  check_file(string $url) :bool
    {
        $headers = get_headers($url);
        return (bool) preg_match('/\bContent-Type:\s+(?:image|audio|video)/i', implode("\n", $headers));
    }



    /**
     * download a file
     *
     * @param string $location
     * @param mixed $file
     * @param string $disk
     * @return mixed
     */
    public function downloadFile(string $location, mixed $file ,string $disk) :mixed
    {
        $filePath = $location . '/' . $file;
        $url = null;

        try {
            if($disk == 's3'){
                (new self())->awsConfig();
                $headers = [
                    'Content-Disposition' => 'attachment; filename="'. $file .'"',
                ];
                $url =  Response::make(\Storage::disk('s3')->get($filePath),200, $headers);
            }
            elseif($disk == 'ftp'){
                (new self())->ftpConfig();
                $headers = [
                    'Content-Disposition' => 'attachment; filename="'. $file .'"',
                ];
                $url =  Response::make(\Storage::disk('ftp')->get($filePath),200, $headers);
            }
            else{
                
                $headers = [
                    'Content-Type' => File::mimeType($filePath),
                ];
                $url =  Response::download( $filePath,$file, $headers);
            }
        } catch (\Throwable $th) {

        }
   
        return $url;;
    }

     
}