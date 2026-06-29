# Contributing

Terima kasih atas minat Anda untuk berkontribusi pada TokoKu.

## Cara Berkontribusi

1. Fork repository ini
2. Buat branch baru: `git checkout -b feature/nama-fitur`
3. Commit perubahan: `git commit -m "feat: deskripsi singkat"`
4. Push ke branch Anda: `git push origin feature/nama-fitur`
5. Buat Pull Request

## Standar Commit

- `feat:` fitur baru
- `fix:` perbaikan bug
- `docs:` perubahan dokumentasi
- `style:` perubahan style (tanpa mengubah logika)
- `refactor:` refactoring kode
- `test:` perubahan test
- `chore:` maintenance

## Sebelum Submit PR

- Pastikan semua test pass: `php artisan test`
- Pastikan build sukses: `npm run build`
- Pastikan tidak ada syntax error: `php -l` untuk file PHP
- Jelaskan perubahan di deskripsi PR

## Code Style

- Ikuti PSR-12 untuk PHP
- Gunakan Tailwind CSS untuk styling
- Gunakan Alpine.js untuk interaksi ringan
- Tulis test untuk fitur baru
