# TODO - Fitur Pencarian Berita

## Plan:
1. [x] Analisis kode yang ada
2. [x] Modify `BeritaController.php` - menambahkan logika pencarian di method `index()`
3. [x] Modify `index.blade.php` - menambahkan form pencarian dan mempertahankan query di pagination
4. [x] Test functionality

## Step 2: Modify Controller (DONE)
- Acceptance Criteria: Method index() menerima parameter 'keyword' dari query URL
- Status: COMPLETE - Method `index()` now accepts `keyword` parameter and searches in `judul` and `konten` fields

## Step 3: Modify View (DONE)
- Acceptance Criteria:
  - Input pencarian terhubung dengan controller - DONE
  - Keyword saat ini ditampilkan - DONE
  - Tombol untuk清除搜索 (清除搜索) - DONE
  - Pagination mempertahankan query pencarian - DONE (using `->appends($request->query())`)
- Status: COMPLETE

## Step 4: Test
- Acceptance Criteria: Mengakses /admin/berita?keyword=vaksin 显示hanya包含 kata "vaksin" 的新闻
- Status: COMPLETE
