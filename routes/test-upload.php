<?php
// Simple test upload form
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Upload</title>
</head>
<body>
    <h1>Test Photo Upload</h1>
    
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2>Upload Results:</h2>
        <pre>
        POST Data: <?php print_r($_POST); ?>
        FILES Data: <?php print_r($_FILES); ?>
        </pre>
        
        <?php if (isset($_FILES['photos'])): ?>
            <p>Files uploaded successfully detected!</p>
            <?php foreach ($_FILES['photos']['name'] as $key => $name): ?>
                <p>File <?php echo $key; ?>: <?php echo $name; ?> (<?php echo $_FILES['photos']['size'][$key]; ?> bytes)</p>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="photos">Photos:</label>
            <input type="file" name="photos[]" multiple accept="image/*">
        </div>
        <button type="submit">Test Upload</button>
    </form>
</body>
</html>