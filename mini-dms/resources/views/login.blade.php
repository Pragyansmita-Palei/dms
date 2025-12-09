<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini DMS Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="flex flex-col justify-center items-center">
        <h1 class="text-3xl font-bold mb-6">Mini DMS Login</h1>
        <div class="flex gap-6">
            <a href="{{ route('login') }}"
               class="px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Admin / Customer Login
            </a>
        </div>
    </div>

</body>
</html>
