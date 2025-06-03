<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ImagesController extends Controller
{
    /**
     * Serve an image from storage
     * 
     * @param string $image_path The image filename
     * @return Response|BinaryFileResponse
     */
    public function getImage(string $image_path)
    {
        try {
            // Sanitize the image path to prevent directory traversal attacks
            $image_path = $this->sanitizePath($image_path);

            // Define the storage path for quiz images (flat structure)
            $storagePath = storage_path('app/public/quiz_images/' . $image_path);


            // Check if file exists
            if (!File::exists($storagePath)) {
                return response()->json([
                    'error' => 'Image not found',
                    'path' => $image_path
                ], 404);
            }

            // Validate file type (security measure)
            $allowedMimeTypes = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
                'image/webp',
                'image/svg+xml',
                'image/avif'
            ];

            $mimeType = File::mimeType($storagePath);

            if (!in_array($mimeType, $allowedMimeTypes)) {
                return response()->json([
                    'error' => 'Invalid file type'
                ], 400);
            }

            // Get file info
            $fileSize = File::size($storagePath);
            $fileName = basename($storagePath);

            // Create response with appropriate headers
            $response = new BinaryFileResponse($storagePath);
            $response->headers->set('Content-Type', $mimeType);
            $response->headers->set('Content-Length', $fileSize);
            $response->headers->set('Cache-Control', 'public, max-age=3600'); // Cache for 1 hour
            $response->headers->set('Content-Disposition', 'inline; filename="' . $fileName . '"');

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load image',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get image information without serving the file
     * 
     * @param string $image_path The image filename
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImageInfo(string $image_path)
    {
        try {
            $image_path = $this->sanitizePath($image_path);
            $storagePath = storage_path('app/public/quiz_images/' . $image_path);

            if (!File::exists($storagePath)) {
                return response()->json([
                    'error' => 'Image not found',
                    'path' => $image_path
                ], 404);
            }

            $imageInfo = getimagesize($storagePath);
            $fileSize = File::size($storagePath);
            $mimeType = File::mimeType($storagePath);
            $lastModified = File::lastModified($storagePath);

            return response()->json([
                'success' => true,
                'data' => [
                    'filename' => basename($image_path),
                    'path' => $image_path,
                    'width' => $imageInfo[0] ?? null,
                    'height' => $imageInfo[1] ?? null,
                    'mime_type' => $mimeType,
                    'size_bytes' => $fileSize,
                    'size_human' => $this->formatBytes($fileSize),
                    'last_modified' => date('Y-m-d H:i:s', $lastModified),
                    'url' => route('images.get', ['image_path' => $image_path])
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to get image information',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all available images
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listImages(Request $request)
    {

        try {
            $search = $request->query('search', '');
            $page = (int) $request->query('page', 1);
            $perPage = (int) $request->query('per_page', 20);

            $basePath = storage_path('app/public/quiz_images');


            if (!File::isDirectory($basePath)) {
                return response()->json([
                    'error' => 'Images directory not found'
                ], 404);
            }

            $files = File::files($basePath);
            $images = [];

            foreach ($files as $file) {
                $mimeType = File::mimeType($file->getPathname());

                // Only include image files
                if (strpos($mimeType, 'image/') === 0) {
                    $filename = $file->getFilename();

                    // Apply search filter if provided
                    if ($search && stripos($filename, $search) === false) {
                        continue;
                    }

                    $images[] = [
                        'filename' => $filename,
                        'path' => $filename,
                        'size' => $file->getSize(),
                        'size_human' => $this->formatBytes($file->getSize()),
                        'mime_type' => $mimeType,
                        'last_modified' => date('Y-m-d H:i:s', $file->getMTime()),
                        'url' => route('images.get', ['image_path' => $filename])
                    ];
                }
            }

            // Sort by filename
            usort($images, function ($a, $b) {
                return strcmp($a['filename'], $b['filename']);
            });

            // Apply pagination
            $total = count($images);
            $offset = ($page - 1) * $perPage;
            $paginatedImages = array_slice($images, $offset, $perPage);

            return response()->json([
                'success' => true,
                'data' => [
                    'images' => $paginatedImages,
                    'pagination' => [
                        'current_page' => $page,
                        'per_page' => $perPage,
                        'total' => $total,
                        'total_pages' => ceil($total / $perPage),
                        'has_more' => ($offset + $perPage) < $total
                    ],
                    'search' => $search
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to list images',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sanitize file path to prevent directory traversal
     * 
     * @param string $path
     * @return string
     */
    private function sanitizePath(string $path): string
    {
        // Remove any attempts at directory traversal
        $path = str_replace(['../', '.\\', '..\\'], '', $path);

        // Remove leading slashes and get just the filename
        $path = basename($path);

        return $path;
    }

    /**
     * Format bytes into human readable format
     * 
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
