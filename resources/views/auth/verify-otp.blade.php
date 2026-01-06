<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Verifikasi Dua Langkah</h2>
            <p class="text-gray-600 text-sm mt-2">
                Kami telah mengirimkan kode 6 digit ke email Anda.
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('otp.verify') }}">
            @csrf

            <div class="mb-4">
                <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">Kode OTP</label>
                <input id="otp" type="text" name="otp" required autofocus maxlength="6"
                       class="shadow appearance-none border rounded w-full py-3 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline text-center text-xl tracking-widest" 
                       placeholder="123456" />
                
                @error('otp')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('otp.resend') }}" class="text-sm text-blue-600 hover:text-blue-800 hover:underline">
                    Kirim ulang kode?
                </a>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                    Verifikasi
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center border-t pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-gray-500 text-sm hover:text-gray-700 underline">
                    Batal & Logout
                </button>
            </form>
        </div>
    </div>

</body>
</html>