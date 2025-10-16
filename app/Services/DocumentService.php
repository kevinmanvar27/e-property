<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * Handle document upload
     */
    public function handleDocumentUpload($document, $prefix)
    {
        if ($document) {
            $filename = $prefix . '_' . time() . '.' . $document->getClientOriginalExtension();
            // Storage::disk('documents')->putFileAs('', $document, $filename);

            Storage::disk('public')->putFileAs('documents', $document, $filename);

            return $filename;
        }

        return null;
    }

    /**
     * Delete a document file
     */
    public function deleteDocumentFile($filename)
    {
        // if ($filename && Storage::disk('documents')->exists($filename)) {
        //     Storage::disk('documents')->delete($filename);
        // }

        if (Storage::disk('public')->exists('documents/' . $filename) && $filename) {
            Storage::disk('public')->delete('documents/' . $filename);
        } 
    }

    /**
     * Handle document uploads for a property
     */
    public function handlePropertyDocumentUploads($request, Property $property, $propertyType)
    {
        $data = [];

        // Handle document uploads (only for land/jamin)
        if ($propertyType !== 'plot') {
            if ($request->hasFile('document_7_12')) {
                // Delete old document if exists
                if ($property->document_7_12) {
                    $this->deleteDocumentFile($property->document_7_12);
                }

                $filename = $this->handleDocumentUpload($request->file('document_7_12'), 'doc_7_12');
                $data['document_7_12'] = $filename;
            }

            if ($request->hasFile('document_8a')) {
                // Delete old document if exists
                if ($property->document_8a) {
                    $this->deleteDocumentFile($property->document_8a);
                }

                $filename = $this->handleDocumentUpload($request->file('document_8a'), 'doc_8a');
                $data['document_8a'] = $filename;
            }
        }

        return $data;
    }
}
