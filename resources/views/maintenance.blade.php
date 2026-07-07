<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Maintenance - TokoKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 flex items-center justify-center px-4">
    <div class="max-w-lg w-full text-center">
        <div class="mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/30 mb-6">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.737-.483l1.665-.948m-7.478 1.461l-1.665-.948m7.478 1.461L18.5 13.5m-7.478-1.461L7.5 10.5m0 0L5.5 9.5m2 1l1.665-.948M5.5 9.5l-1.665-.948m0 0a2.548 2.548 0 103.586-3.586L9.5 7.5" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 mb-3">Sedang Dalam Perbaikan</h1>
            <p class="text-slate-600 leading-relaxed">
                Kami sedang melakukan pemeliharaan sistem untuk memberikan pengalaman berbelanja yang lebih baik.
                Mohon coba kembali dalam beberapa saat.
            </p>
        </div>
        <div class="glass rounded-2xl p-6 shadow-soft border border-white/60">
            <div class="flex items-center justify-center gap-2 text-sm text-slate-500">
                <svg class="w-4 h-4 text-blue-500 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>Estimasi selesai: 1-2 jam</span>
            </div>
        </div>
        <p class="mt-8 text-xs text-slate-400">
            &copy; {{ date('Y') }} TokoKu. Belanja Mudah, Jualan Untung.
        </p>
    </div>
</body>
</html>
