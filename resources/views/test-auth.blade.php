<!DOCTYPE html>
<html>
<head>
    <title>Auth Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Authentication Test</h1>
    
    @auth
        <p>User is authenticated: {{ auth()->user()->email }}</p>
        <p>User ID: {{ auth()->id() }}</p>
    @else
        <p>User is not authenticated</p>
    @endauth
    
    <button onclick="testCartAdd()">Test Cart Add</button>
    
    <script>
        function testCartAdd() {
            console.log('Testing cart add...');
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: 1,
                    quantity: 1
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response URL:', response.url);
                console.log('Response redirected:', response.redirected);
                
                return response.text();
            })
            .then(data => {
                console.log('Response data:', data);
                alert('Response: ' + data);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        }
    </script>
</body>
</html>