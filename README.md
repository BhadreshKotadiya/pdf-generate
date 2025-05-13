<h1>PDF Conversion API</h1>
    <p>This API allows users to upload various types of documents (such as DOCX, XLSX, PPTX, etc.) and convert them into PDF format. If the uploaded file is already a PDF, the API simply returns a message indicating so. Otherwise, the file is processed and converted to PDF.</p>
    <h2>Features</h2>
    <ul>
        <li><strong>File Upload</strong>: Users can upload documents in various formats like DOCX, XLSX, CSV, PPTX, etc.</li>
        <li><strong>PDF Conversion</strong>: Uploaded documents are converted to PDF format using <code>LibreOffice</code>.</li>
        <li><strong>Error Handling</strong>: Proper error handling for different scenarios such as failed uploads or conversion issues.</li>
        <li><strong>File Download</strong>: After conversion, the user can download the newly generated PDF.</li>
    </ul>
    <h2>Installation</h2>
    <p>To use this API, follow the instructions below:</p>
    <h3>1. Clone the Repository</h3>
    <pre><code>git clone https://github.com/your-username/pdf-conversion-api.git
cd pdf-conversion-api</code></pre>
    <h3>2. Install Dependencies</h3>
    <p>Make sure you have Composer installed. Run the following command to install the necessary PHP dependencies:</p>
    <pre><code>composer install</code></pre>
    <h3>3. Set Up Storage</h3>
    <p>Make sure that the storage folder is properly linked. You can do this by running:</p>
    <pre><code>php artisan storage:link</code></pre>
    <p>This creates a symbolic link for the <code>public/storage</code> directory.</p>
    <h3>4. Install LibreOffice</h3>
    <p>The conversion relies on <code>LibreOffice</code> being installed on the server. You can install it using the following command on Ubuntu:</p>
    <pre><code>sudo apt-get install libreoffice</code></pre>
    <p>For other operating systems, please refer to the <a href="https://www.libreoffice.org/download/download/" target="_blank">LibreOffice download page</a>.</p>
    <h3>5. Set Up Environment</h3>
    <p>Ensure that your <code>.env</code> file is configured correctly with the necessary database credentials.</p>
    <pre><code>DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password</code></pre>
    <h3>6. Run Migrations</h3>
    <p>Run the migrations to set up the database:</p>
    <pre><code>php artisan migrate</code></pre>
    <h3>7. Start the Application</h3>
    <p>Start the development server using the following command:</p>
    <pre><code>php artisan serve</code></pre>
    <p>The API will be accessible at <code>http://localhost:8000</code>.</p>
    <h2>API Endpoints</h2>
    <h3>1. POST /api/make-pdf</h3>
    <p>This endpoint is used to upload a document for conversion into PDF.</p>
    <h4>Request Parameters:</h4>
    <ul>
        <li><strong>upload_file</strong> (required): The file to be uploaded (in various document formats like DOCX, XLSX, PPTX, etc.).</li>
    </ul>
    <h4>Example Request:</h4>
    <pre><code>POST /api/generate/pdf
Content-Type: multipart/form-data

{
  "upload_file": &lt;File&gt;
}</code></pre>
    <h4>Response:</h4>
    <ul>
        <li><strong>Status Code:</strong> 200</li>
        <li><strong>Success Response:</strong>
            <pre><code>{
  "success": true,
  "message": "File successfully converted to PDF.",
  "data": {
    "path": "http://localhost/storage/files/converted-file.pdf"
  }
}</code></pre>
        </li>
        <li><strong>Failure Response:</strong>
            <pre><code>{
  "success": false,
  "message": "Internal Server Error."
}</code></pre>
        </li>
        <li>If the file is already a PDF:
            <pre><code>{
  "success": true,
  "message": "Uploaded file is already pdf.",
  "data": {
    "file": "original-file.pdf"
  }
}</code></pre>
        </li>
    </ul>
    <h2>Error Handling</h2>
    <p>The API handles various errors such as:</p>
    <ul>
        <li>File upload failure</li>
        <li>File format not supported</li>
        <li>Conversion failure</li>
    </ul>
    <p>Each error will return a specific message indicating the issue.</p>
    <h2>Logs</h2>
    <p>All errors are logged using the <code>logError()</code> function, and can be found in the Laravel logs located at <code>storage/logs/laravel.log</code>.</p>
    <h2>License</h2>
    <p>This project is open-source and available under the <a href="LICENSE" target="_blank">MIT License</a>.</p>
