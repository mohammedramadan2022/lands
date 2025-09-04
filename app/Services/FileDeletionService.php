<?php
namespace App\Services;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class FileDeletionService
{
    /**
     * Delete a file from a model using Spatie Media Library.
     *
     * @param string $modelClass The model class name (e.g., App\Models\Project).
     * @param int $modelId The ID of the model.
     * @param string $fileName The name of the file to delete.
     * @param string|null $collectionName Optional: The name of the media collection.
     * @return bool True if the file was deleted, false otherwise.
     */
    public static function deleteFile(string $modelClass, int $modelId, string $fileName, ?string $collectionName = null): bool
    {
        // Check if the model exists
        if (!class_exists("App\\Models\\".$modelClass)) {
            throw new \Exception("Model {$modelClass} does not exist.");
        }

        // Fetch the model
        $model = $modelClass::find($modelId);

        if (!$model || !($model instanceof HasMedia)) {
            throw new \Exception("Invalid model or the model does not implement Spatie HasMedia.");
        }

        // Get media items from the specified collection or all media
        $mediaItems = $collectionName
            ? $model->getMedia($collectionName)
            : $model->getMedia();

        // Find the media item by file name
        foreach ($mediaItems as $mediaItem) {
            if ($mediaItem->file_name === $fileName) {
                $mediaItem->delete();
                return true;
            }
        }

        // File not found
        return false;
    }
}
