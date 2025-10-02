<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Facades\Storage;

class PhotoService
{
    /**
     * Update photo positions for a property
     */
    public function updatePhotoPositions(Property $property, array $positions)
    {
        $photos = json_decode($property->photos, true);
        $newPhotos = [];

        foreach ($positions as $index) {
            if (isset($photos[$index])) {
                $newPhotos[] = $photos[$index];
            }
        }

        $property->photos = json_encode($newPhotos);
        $property->save();

        return $property;
    }

    /**
     * Delete a specific photo from a property
     */
    public function deletePhoto(Property $property, $photoIndex)
    {
        $photos = json_decode($property->photos, true);

        if (! isset($photos[$photoIndex])) {
            throw new \Exception('Photo not found');
        }

        // Delete the photo file
        $photoPath = $photos[$photoIndex];
        if (Storage::disk('photos')->exists($photoPath)) {
            Storage::disk('photos')->delete($photoPath);
        }

        // Remove from array
        unset($photos[$photoIndex]);

        // Reindex array
        $photos = array_values($photos);

        $property->photos = json_encode($photos);
        $property->save();

        return $property;
    }
}
