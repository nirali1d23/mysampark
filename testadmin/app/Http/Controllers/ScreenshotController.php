<?php

namespace App\Http\Controllers;
use App\Models\Image as Images;
use Illuminate\Http\Request;
use App\Models\Frame; // Assuming you have a Frame model for your frames table
use App\Models\Ratio;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Helpers\Whatsapp;
use FFMpeg\FFMpeg;
use FFMpeg\Exception\RuntimeException;
class ScreenshotController extends Controller
{
    public function takeScreenshot()
    {
        $images = Images::all(); 
        // Get all files from the 'Bottom Bar Content' directory
        $bottomBarFiles = File::files(public_path('images/Bottom Bar Assets'));
        foreach ($images as $imagerecord)
        {      
            $mainImage = Image::make(public_path('images/' . $imagerecord->image));
            $mainImageWidth = $mainImage->width();
            $mainImageHeight = $mainImage->height();
            // Loop through each bottom image in 'Bottom Bar Content'
            foreach ($bottomBarFiles as $index => $bottomBarFile) 
            {
                 // Clone the main image so each combination is unique
                $newMainImage = clone $mainImage;
                // Make the bottom image and resize it to fit the main image width
                $frameImage = Image::make($bottomBarFile->getPathname())->resize($mainImageWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $newMainImage->insert($frameImage, 'bottom');
                $newMainImage->text('+91 828 182 4556',  $newMainImage->width() -350, $newMainImage->height() - 20, function($font) {
                    $font->file(public_path('static/Montserrat-Bold.ttf'));
                    $font->size(28);
                    $font->color('#FFFFFF');
                    $font->align('left');
                });
                // Add the email (bottom left)
                $newMainImage->text('saurabhinfosys@gmail.com', 198, $newMainImage->height() - 32, function($font) {
                    $font->file(public_path('static/Montserrat-Bold.ttf'));
                    $font->size(13);
                    $font->color('#FFFFFF');
                    $font->align('center');
                });
                // Add website (bottom right)
               $newMainImage->text('www.saurabhinfosys.com', $newMainImage->width() - 520, $newMainImage->height() - 32, function($font) {
                    $font->file(public_path('static/Montserrat-Bold.ttf'));
                    $font->size(13);
                    $font->color('#FFFFFF');
                    $font->align('right');
                });
                // Add location (center middle)
                $text = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
                $maxWidth = 330;  // Max width in pixels
                $maxHeight = 81.98;  // Max height in pixels
                $fontSize = 18; // Example font size
        // Approximate character limit per line based on the width (adjust as needed)
        $charactersPerLine = floor($maxWidth / ($fontSize * 0.6)); // Estimation: 0.6 based on average character width for the font
        // Split the text into words
        $words = explode(' ', $text);
        // Wrap text based on the character limit
        $wrappedText = '';
        $currentLine = '';
        foreach ($words as $word) {
            // Check if adding the next word exceeds the line limit
            if (strlen($currentLine . ' ' . $word) > $charactersPerLine) {
                // Add current line to wrapped text and reset current line
                $wrappedText .= trim($currentLine) . "\n";
                $currentLine = $word; // Start new line with the current word
            } else {
                // Add word to the current line
                $currentLine .= ' ' . $word;
            }
        }
        // Add any remaining text from the last line
        if (!empty($currentLine)) {
            $wrappedText .= trim($currentLine);
        }
        // Approximate the number of lines based on the height constraint
        $lineHeight = $fontSize * 1.2; // Line height as a multiple of font size (adjustable)
        $maxLines = floor($maxHeight / $lineHeight);
        
        // Limit the number of lines to fit within the height
        $lines = explode("\n", $wrappedText);
        $limitedText = implode("\n", array_slice($lines, 0, $maxLines));
        
        // Apply the text to the image
        $newMainImage->text($limitedText, $newMainImage->width() - 830, $newMainImage->height() -130, function($font) {
            $font->file(public_path('fonts/Roboto-Bold.ttf'));
            $font->size(18);
            $font->color('#ffff');
            $font->align('center');
            $font->valign('middle');
        });
        $logo = Image::make(public_path('images/logo.jpeg'));
        $logoWidth = $logo->width();
        $logoHeight = $logo->height();
        $x = (int)(($mainImageWidth - $logoWidth) / 2);
        $y = 100;
        $newMainImage->insert($logo, 'top-left', $x, $y);
                // Define the unique output image path for each combination
        $outputImagePath = public_path('images/new/output_' . $imagerecord->id . '_frame_' . $index . '.jpg');
                // Save the new image
        $newMainImage->save($outputImagePath);
            }
        }
        return response()->json(['message' => 'Images created successfully!', 'output_path' => 'images/new/']);
    }

    public function testing() 
    {
        $response =  Whatsapp::sendmessage('918320766613','https://fastly.picsum.photos/id/381/536/354.jpg?hmac=UrahXEEnGTL3Aa0mUNERzMBn2X2Wf4POTUxC8MjRW1o');
        dd($response->json());

    }
    
    public function msgtesting()
    {
         $response =  Whatsapp::sendotp('918320766613','1111');
        
         dd($response);

        
    }




    public function addBottomFramee(Request $request)
    {
        $inputVideoPath = public_path('videos/input.mp4');
        $frameImagePath = public_path('images/Bottom Bar Assets/1 Demo.png');
        $outputVideoPath = public_path('videos/neww.mp4');
        
        // Get the video dimensions
        $videoDimensionsCommand = "C:\\ffmpeg\\bin\\ffmpeg -i \"$inputVideoPath\" 2>&1";
        $videoDimensionsOutput = shell_exec($videoDimensionsCommand);
        
        // Extract video dimensions
        if (preg_match('/Video:.*?(\d{2,5})x(\d{2,5})/', $videoDimensionsOutput, $matches)) {
            $videoWidth = $matches[1];
            $videoHeight = $matches[2];
        } else {
            echo "Failed to extract video dimensions.";
            exit;
        }
        
        // Hardcoding the frame (image) dimensions for now
        $frameWidth = 200; // Width of the frame image
        $frameHeight = 50; // Height of the frame image
        
        // Position the frame at the bottom-center of the video
        $overlayX = ($videoWidth - $frameWidth) / 2;
        $overlayY = $videoHeight - $frameHeight;
        
        // FFmpeg command to apply the frame (image) overlay
        $ffmpegCommand = "C:\\ffmpeg\\bin\\ffmpeg -i \"$inputVideoPath\" -i \"$frameImagePath\" -filter_complex \"overlay=$overlayX:$overlayY\" \"$outputVideoPath\"";
        
        // Execute the FFmpeg command
        exec($ffmpegCommand . " 2>&1", $output, $returnVar);
        
        // Check if the command was successful
        if ($returnVar === 0) {
            echo "Frame applied successfully!";
        } else {
            echo "Failed to apply frame.";
            echo "<pre>";
            print_r($output);  // Show the detailed error messages from FFmpeg
            echo "</pre>";
        }
        
   }
}