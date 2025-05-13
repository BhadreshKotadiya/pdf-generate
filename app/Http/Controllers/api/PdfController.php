<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PdfRequest;
use App\Models\PdfGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    public function makePdf(PdfRequest $request)
    {
        try {
            $fileName =  $request->file('upload_file')->getClientOriginalName();
            $filePath = $request->file('upload_file')->storeAs('public/files', $fileName);
            $pub_path = public_path('storage/files/' . $fileName);

            if ($request->file('upload_file')->getClientOriginalExtension() == "pdf") {
                return uniResponse(true, 'Uploaded file is already pdf.', ['file' => $fileName], 200);
            }
            $model = PdfGenerate::create(['original_document' => $fileName]);

            $convertedPdfName = $this->convertToPdf($pub_path);
            if ($convertedPdfName) {
                $fileDownload = asset('storage/files/' . $convertedPdfName);
                $model->converted_pdf = $convertedPdfName;
                $model->save();
                if ($model) {
                    return uniResponse(true, 'File successfully converted to PDF.', ['path' => $fileDownload], 200);
                } else {
                    return uniResponse(true, 'Something went wrong', '', 500);
                }
            } else {
                return uniResponse(true, 'Failed to convert document to PDF.', '', 500);
            }
        } catch (\Exception $e) {
            logError($e, 500);
            $errorData['message'] = 'Internal Server Error.';
            return uniResponse(false, $errorData, '', 500);
        }
    }
    protected function convertToPdf($filePath)
    {
        try {
            if ($filePath) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                // Handle different document types
                switch ($extension) {
                    case 'csv':
                    case 'ods':
                    case 'xls':
                    case 'xlsx':
                    case 'odt':
                    case 'txt':
                    case 'doc':
                    case 'docx':
                    case 'ppt':
                    case 'pptx':
                        return $this->docsToPdf($filePath);
                        break;
                    default:
                        return null;
                }
            }
        } catch (\Exception $e) {
            logError($e, 500);
            $errorData['message'] = 'Internal Server Error.';
            return uniResponse(false, $errorData, '', 500);
        }
    }
    protected function docsToPdf($filePath)
    {
        try {
            $command = sprintf(
                'libreoffice --convert-to pdf %s --outdir %s',
                escapeshellarg($filePath),
                escapeshellarg(dirname($filePath))
            );
            exec($command);
            $fileName = pathinfo($filePath, PATHINFO_FILENAME);
            $generatedPdfName = $fileName . '.' . 'pdf';
            return $generatedPdfName;
        } catch (\Exception $e) {
            logError($e, 500);
            $errorData['message'] = 'Internal Server Error.';
            return uniResponse(false, $errorData, '', 500);
        }
    }
}
