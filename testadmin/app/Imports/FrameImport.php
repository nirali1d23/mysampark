<?php

namespace App\Imports;

use App\Models\Frame;
use App\Models\Frameicon;
use App\Models\FrameRatioApp;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class FrameImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $dummyImagePath = 'images/Bottom Bar Assets/1731321387.png';

        foreach ($rows as $index => $row) {
            // Skip the header row
            if ($index === 0) {
                continue;
            }

            // Insert into `frames` table
            $frame = Frame::create([
                'fram_path' => $row[0] ?? $dummyImagePath,
                'frame_height' => $row[1] ?? 0, // Default to 0 if height is not provided
            ]);

            $icons = [
                'address' => [
                    'x' => $row[2] ?? 0,
                    'y' => $row[3] ?? 0,
                    'color' => $row[4] ?? '#000000',
                    'size' => $row[5] ?? null,
                    'reverse_icon_value' => $row[6] ?? null,
                ],
                'mobile' => [
                    'x' => $row[7] ?? 0,
                    'y' => $row[8] ?? 0,
                    'color' => $row[9] ?? '#000000',
                    'size' => $row[10] ?? null,
                    'reverse_icon_value' => $row[11] ?? null,
                ],
                'website' => [
                    'x' => $row[12] ?? 0,
                    'y' => $row[13] ?? 0,
                    'color' => $row[14] ?? '#000000',
                    'size' => $row[15] ?? null,
                    'reverse_icon_value' => $row[16] ?? null,
                ],
                'email' => [
                    'x' => $row[17] ?? 0,
                    'y' => $row[18] ?? 0,
                    'color' => $row[19] ?? '#000000',
                    'size' => $row[20] ?? null,
                    'reverse_icon_value' => $row[21] ?? null,
                ],
                'company' => [
                    'x' => $row[22] ?? 0,
                    'y' => $row[23] ?? 0,
                    'color' => $row[24] ?? '#000000',
                    'size' => $row[25] ?? null,
                    'reverse_icon_value' => $row[26] ?? null,
                ],
            ];
            
          

            foreach ($icons as $type => $data) {
                // Use dummy image for icons
                $iconName = "dummy_{$type}.png";
                Frameicon::create([
                    'frame_id' => $frame->id,
                    'icon_type' => $type,
                    'x' => $data['x'],
                    'y' => $data['y'],
                    'color' => $data['color'],
                    'icon_image' => $iconName,
                    'size' => $data['size'],
                    'reverse_icon_value' => $data['reverse_icon_value'],
                ]);
            }

            // Insert into `frame_ratio_apps` table
            $elementTypes = ['address', 'mobile', 'website', 'email', 'company'];
            foreach ($elementTypes as $type) {
                FrameRatioApp::create([
                    'frame_id' => $frame->id,
                    'element_type' => $type,
                    'x_left' => $row[7] ?? 0,
                    'y_top' => $row[8] ?? 0,
                    'font_size' => $row[9] ?? 12,
                    'font_color' => $row[10] ?? '#000000',
                    'monst' => $row[11] ?? null,
                    'height' => $row[12] ?? null,
                    'width' => $row[13] ?? null,
                    'reverse_value' => $row[14] ?? null,
                ]);
            }
        }
    }
}
