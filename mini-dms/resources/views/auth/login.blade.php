<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini DMS Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-screen flex items-center justify-center bg-gradient-to-r from-blue-400 to-pink-500">

    <div class="bg-white rounded-2xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login to Your Account</h2>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-4 text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-1">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
            </div>

            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    <span class="ml-2 text-sm text-gray-600">Remember Me</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:underline">
                    Forgot your password?
                </a>
            </div>

            <button type="submit"
                class="w-full py-2 rounded-lg text-white font-semibold bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 transition">
                Log In
            </button>
        </form>

        <!-- Register link -->
        <p class="mt-4 text-center text-gray-600 text-sm">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-purple-600 hover:underline">Register here</a>
        </p>
    </div>

</body>
</html>
